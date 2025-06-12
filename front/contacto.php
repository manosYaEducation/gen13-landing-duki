<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (empty($nombre)) {
        $errors[] = "El nombre es requerido";
    }
    if (empty($email)) {
        $errors[] = "El email es requerido";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El email no es válido";
    }
    if (empty($asunto)) {
        $errors[] = "El asunto es requerido";
    }
    if (empty($mensaje)) {
        $errors[] = "El mensaje es requerido";
    }

    if (empty($errors)) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.resend.com/emails');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer re_QMj6U8Er_MSbc1nnCFXJ8TnEnLBRytrrh',
                'Content-Type: application/json'
            ]);
            
            $data = [
                'from' => 'onboarding@resend.dev',
                'to' => 'sebastiansch.dev@gmail.com',
                'subject' => "LANDING DUKI - ASUNTO: $asunto",
                'html' => "
                    <h2>Nuevo mensaje de contacto</h2>
                    <p><strong>Nombre:</strong> $nombre</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Asunto:</strong> $asunto</p>
                    <p><strong>Mensaje:</strong></p>
                    <p>$mensaje</p>
                "
            ];
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if ($httpCode === 200) {
                $success = true;
            } else {
                throw new Exception("Error al enviar el mensaje: " . $response);
            }
            
            curl_close($ch);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Ameri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .contact-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-info {
            padding-right: 40px;
        }

        .contact-info h2 {
            font-family: 'Anton', sans-serif;
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .contact-info p {
            color: #ccc;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-5px);
        }

        .info-item i {
            font-size: 24px;
            color: #e03838;
            margin-right: 15px;
            margin-top: 5px;
        }

        .info-item h3 {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 5px;
            font-family: 'Anton', sans-serif;
        }

        .info-item p {
            color: #ccc;
            margin: 0;
            font-size: 1rem;
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #fff;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #e03838;
            box-shadow: 0 0 0 2px rgba(224, 56, 56, 0.2);
        }

        .submit-btn {
            background: linear-gradient(45deg, #e03838, #ff4d4d);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(224, 56, 56, 0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #28a745;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 768px) {
            .contact-content {
                grid-template-columns: 1fr;
                padding: 20px;
            }

            .contact-info {
                padding-right: 0;
            }

            .contact-container {
                margin: 80px auto 30px;
            }
        }
    </style>
</head>
<body>
    <div class="contact-container">
        <div class="contact-content">
            <div class="contact-info">
                <div>
                    <a href="/landing-duki/front/tienda.php" class="back-btn" style="background: #e03838; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; margin-bottom: 40px; font-size: 1.1rem; letter-spacing: 1px; box-shadow: 0 0 16px #e03838cc; transition: all 0.2s;">VOLVER A LA TIENDA</a>
                </div>
                <h2>Contacto</h2>
                <p>¿Tienes alguna pregunta o sugerencia? ¡Nos encantaría escucharte!</p>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h3>Email</h3>
                        <p>contacto@ameri.com</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h3>Teléfono</h3>
                        <p>+1 234 567 890</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Ubicación</h3>
                        <p>Buenos Aires, Argentina</p>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        ¡Mensaje enviado con éxito! Nos pondremos en contacto contigo pronto.
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="asunto">Asunto</label>
                        <input type="text" id="asunto" name="asunto" class="form-control" value="<?php echo htmlspecialchars($asunto ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" class="form-control" rows="5" required><?php echo htmlspecialchars($mensaje ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 