<?php
require_once __DIR__ . '/../db.php';

// Obtener todas las migraciones ejecutadas
$migrationsRun = [];
$result = $conn->query("SHOW TABLES LIKE 'migrations'");

if ($result->num_rows === 0) {
    // Crear tabla de migraciones si no existe
    $conn->query("CREATE TABLE migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        batch INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
}

// Obtener migraciones ya ejecutadas
$result = $conn->query("SELECT migration FROM migrations");
while ($row = $result->fetch_assoc()) {
    $migrationsRun[] = $row['migration'];
}

// Obtener archivos de migración
$migrationFiles = glob(__DIR__ . '/migrations/*.sql');
$batch = $conn->query("SELECT COALESCE(MAX(batch), 0) + 1 as next_batch FROM migrations")->fetch_assoc()['next_batch'];

foreach ($migrationFiles as $file) {
    $migrationName = basename($file);
    
    // Verificar si la migración ya se ejecutó
    if (!in_array($migrationName, $migrationsRun)) {
        echo "Ejecutando migración: $migrationName\n";
        
        // Leer el archivo SQL
        $sql = file_get_contents($file);
        
        // Ejecutar las consultas
        if ($conn->multi_query($sql)) {
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->next_result());
            
            // Registrar la migración
            $stmt = $conn->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
            $stmt->bind_param("si", $migrationName, $batch);
            $stmt->execute();
            
            echo "Migración completada: $migrationName\n";
        } else {
            echo "Error en la migración $migrationName: " . $conn->error . "\n";
        }
    }
}

echo "Todas las migraciones han sido ejecutadas.\n";
