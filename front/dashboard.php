<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}
?>
<!-- Aquí comienza el contenido de tu panel de administración -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Duki Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <style>
body {
    background: #18181c;
    min-height: 100vh;
    font-family: 'Bebas Neue', Arial, sans-serif;
    margin: 0;
    display: flex;
}
.sidebar {
    width: 220px;
    background: #1a1012;
    border-right: 3px solid #6f0001;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2.5rem 1rem 1rem 1rem;
    min-height: 100vh;
    box-shadow: 4px 0 32px #6f0001cc;
}
.sidebar-logo {
    width: 80px;
    margin-bottom: 2rem;
    filter: drop-shadow(0 0 24px #6f0001);
}
.sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: 1.4rem;
    width: 100%;
}
.sidebar-link {
    color: #fff;
    background: #6f0001;
    border-radius: 8px;
    padding: 0.7rem 1rem;
    text-align: center;
    text-decoration: none;
    font-size: 1.2rem;
    letter-spacing: 2px;
    font-weight: bold;
    box-shadow: 0 0 8pxrgba(0, 0, 0, 0.8);
    transition: background 0.2s, color 0.2s;
}
.sidebar-link:hover {
    background: #400208;
    color: #fff;
}
.main-content {
    flex: 1;
    padding: 2.5rem 3rem;
    color: #000;
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}
.dashboard-title {
    font-size: 2.3rem;
    letter-spacing: 2px;
    margin-bottom: 0.5rem;
    text-shadow: 0 0 24px #6f0001, 2px 2px 0 #141418;
}
.dashboard-summary {
    background: #1f1f23;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 0 24px #6f0001cc;
    display: flex;
    gap: 2.5rem;
    justify-content: space-around;
    align-items: center;
}
.summary-item {
    text-align: center;
}
.summary-label {
    color: #c9cfd3;
    font-size: 1.1rem;
    margin-bottom: 0.2rem;
}
.summary-value {
    color: #fff;
    font-size: 2.1rem;
    font-weight: bold;
    text-shadow: 0 0 16px #6f0001cc;
}
.dashboard-actions {
    display: flex;
    gap: 1.6rem;
    margin-top: 1rem;
}
.action-btn {
    background: linear-gradient(90deg, #400208 0%, #6f0001 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 1rem 2.2rem;
    font-size: 1.2rem;
    font-family: 'Bebas Neue', Arial, sans-serif;
    font-weight: bold;
    letter-spacing: 2px;
    box-shadow: 0 0 12px #6f0001cc;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    text-shadow: 0 0 8px #fff, 0 0 6px #6f0001;
}
.action-btn:hover {
    background: linear-gradient(90deg, #6f0001 0%, #400208 100%);
    color: #fff;
    box-shadow: 0 0 24px #6f0001;
}
    </style>
<div class="sidebar">
    <img src="../assets/ameri.png" alt="Logo" class="sidebar-logo">
    <nav class="sidebar-nav">
        <a href="../front/tienda.php" class="sidebar-link">Tienda</a>
        <a href="../index.html" class="sidebar-link">Inicio</a>
        <a href="../logout.php" class="sidebar-link">Salir</a>
    </nav>
</div>
<div class="main-content">
    <div>
        <div class="dashboard-title">Bienvenido/a, <?php echo htmlspecialchars($_SESSION["username"] ?? "Admin"); ?></div>
        <div class="dashboard-summary">
            <div class="summary-item">
                <div class="summary-label">Productos</div>
                <div class="summary-value">
                    <?php 
                    require_once '../db.php';
                    $count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
                    echo $count;
                    ?>
                </div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Pedidos</div>
                <div class="summary-value">-</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Usuarios</div>
                <div class="summary-value">
                    <?php 
                    $ucount = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
                    echo $ucount;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div style="background: #fff2; border-radius: 16px; padding: 2rem; box-shadow: 0 0 24pxrgba(207, 198, 198, 0.8); margin-top: 2rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.2rem;">
            <div style="font-size:1.3rem;font-weight:bold;color:#fff;letter-spacing:1.5px;">Productos recientes</div>
            <button class="action-btn" style="background:#6f0001;" onclick="document.getElementById('modal-producto').style.display='block'">+ Nuevo</button>
        </div>
        <table style="width:100%; border-collapse:collapse; background:#fff1; color:#fff; border-radius:12px; overflow:hidden;">
            <thead>
                <tr style="background:#1a1012; color:#fff;">
                    <th style="padding:10px 8px;">ID</th>
                    <th style="padding:10px 8px;">Imagen</th>
                    <th style="padding:10px 8px;">Nombre</th>
                    <th style="padding:10px 8px;">Precio</th>
                    <th style="padding:10px 8px;">Stock</th>
                    <th style="padding:10px 8px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $prods = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 10");
                while($row = $prods->fetch_assoc()): ?>
                <tr style="background:#23232a; min-height:80px; height:80px;">
                    <td style="padding:12px 8px; text-align:center; vertical-align:middle; font-size:1.08rem; font-family:'Bebas Neue',Arial,sans-serif;"> <?php echo $row['id']; ?> </td>
                    <td style="padding:8px 6px; text-align:center; vertical-align:middle;">
                        <?php if($row['image']): ?>
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="img" style="width:72px; height:72px; object-fit:cover; border-radius:12px; box-shadow:0 0 10px #000; background:#18181c; display:block; margin:auto;">
                        <?php endif; ?>
                    </td>
                    <td style="padding:12px 8px; text-align:center; font-weight:700; color:#fff; letter-spacing:2px; font-size:1.18rem; vertical-align:middle; text-transform:uppercase; font-family:'Bebas Neue',Arial,sans-serif;">
                        <?php echo htmlspecialchars($row['name']); ?>
                    </td>
                    <td style="padding:12px 8px; text-align:center; font-weight:700; color:#e0b800; font-size:1.21rem; vertical-align:middle; font-family:'Bebas Neue',Arial,sans-serif;">
                        <span style="font-size:1.18rem;">$</span><?php echo number_format($row['price'],0,',','.'); ?>
                    </td>
                    <td style="padding:12px 8px; text-align:center; font-weight:600; color:#1fa700; font-size:1.1rem; vertical-align:middle; font-family:'Bebas Neue',Arial,sans-serif;">
                        <span style="font-size:1.05rem;">▲</span> <?php echo $row['stock']; ?>
                    </td>
                    <td style="padding:8px 6px; text-align:center;">
                        <a href="admin_products.php?edit=<?php echo $row['id']; ?>" title="Editar" style="margin-right:10px; display:inline-block; vertical-align:middle;">
    <img src="../assets/icons/pencil.png" alt="Editar" style="width:28px; height:28px; object-fit:contain; filter:drop-shadow(0 0 2px #e0b800); cursor:pointer;">
</a>
<a href="admin_products.php?delete=<?php echo $row['id']; ?>" title="Eliminar" style="display:inline-block; vertical-align:middle;">
    <img src="../assets/icons/trash-x.png" alt="Eliminar" style="width:28px; height:28px; object-fit:contain; filter:drop-shadow(0 0 2px #e03838); cursor:pointer;">
</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<!-- Modal para crear producto -->
<div id="modal-producto" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(24,24,28,0.93);">
    <div style="background:#18181c; max-width:700px; margin:3rem auto; border-radius:14px; box-shadow:0 2px 32px #6f0001cc; padding:2.5rem 2.5rem 1.5rem 2.5rem; position:relative; border:2.5px solid #6f0001; color:#fff;">
        <form method="POST" enctype="multipart/form-data">
            <h3 style="color:#6f0001; font-size:1.32rem; margin-bottom:1.3rem; letter-spacing:1.5px; font-family:'Bebas Neue', Arial, sans-serif;">NUEVO PRODUCTO</h3>
            <label style="font-weight:700; color:#6f0001; letter-spacing:1px;">NOMBRE:</label>
            <input type="text" name="name" required style="width:100%;margin-bottom:13px;background:#23232a;color:#fff;border:1.5px solid #6f0001;border-radius:6px;padding:7px 10px;font-size:1.08rem;">
            <label style="font-weight:700; color:#6f0001; letter-spacing:1px;">PRECIO:</label>
            <input type="number" step="0.01" name="price" required style="width:100%;margin-bottom:13px;background:#23232a;color:#fff;border:1.5px solid #6f0001;border-radius:6px;padding:7px 10px;font-size:1.08rem;">
            <label style="font-weight:700; color:#6f0001; letter-spacing:1px;">STOCK:</label>
            <input type="number" name="stock" required style="width:100%;margin-bottom:13px;background:#23232a;color:#fff;border:1.5px solid #6f0001;border-radius:6px;padding:7px 10px;font-size:1.08rem;">
            <label style="font-weight:700; color:#6f0001; letter-spacing:1px;">IMAGEN:</label>
            <input type="file" name="image" accept="image/*" style="margin-bottom:16px;color:#fff;">
            <div style="margin-top:1.6rem;display:flex;gap:1.2rem;">
                <button type="submit" name="add_product" class="action-btn" style="background:#6f0001;color:#fff;font-size:1.13rem;font-family:'Bebas Neue',Arial,sans-serif;letter-spacing:1.2px;padding:0.72rem 2.3rem;border-radius:8px;border:none;box-shadow:0 0 8px #6f0001cc;">CREAR</button>
                <button type="button" onclick="document.getElementById('modal-producto').style.display='none'" class="action-btn" style="background:#23232a;color:#fff;font-size:1.13rem;font-family:'Bebas Neue',Arial,sans-serif;letter-spacing:1.2px;padding:0.72rem 2.3rem;border-radius:8px;border:2px solid #6f0001;box-shadow:0 0 8px #6f0001cc;">CANCELAR</button>
            </div>
        </form>
        <button onclick="document.getElementById('modal-producto').style.display='none'" style="position:absolute;top:12px;right:18px;font-size:1.5rem;background:none;border:none;color:#fff;cursor:pointer;">&times;</button>
    </div>
</div>

<?php
// Lógica para crear producto desde el dashboard
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
        $img_name = uniqid('prod_') . '_' . basename($_FILES['image']['name']);
        $target = '../assets/tienda/' . $img_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_url = '/duki/assets/tienda/' . $img_name;
        }
    }
    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sdis', $name, $price, $stock, $image_url);
    if ($stmt->execute()) {
        echo '<script>alert("Producto agregado correctamente"); location.href="dashboard.php";</script>';
        exit;
    } else {
        echo '<script>alert("Error al guardar producto");</script>';
    }
}
?>

</body>
</html>
