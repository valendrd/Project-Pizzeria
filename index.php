<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria Pizze Il Napolitano</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Link font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Estilos para la promoción del día -->
    <style>
        .promotion-banner {
            background-color: #f8d7da;
            color: #721c24;
            text-align: center;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 2px solid #f5c6cb;
            margin-bottom: 20px;
        }

        .promotion-banner .promotion-message {
            margin: 0;
        }
    </style>
</head>

<body>
    <header>
        <div id="header-container">
            <div id="logo">
                <img src="img/pizza.svg" alt="">
                <img class="logo-text" src="img/text.svg" alt="">
            </div>
            <nav>
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">NOSOTROS</a></li>
                    <li><a href="sucursales.php">SUCURSALES & DELIVERY</a></li>
                    <li><a href="#">CONTACTO</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Agregar Promoción del Día Aquí -->
    <div class="promotion-banner">
        <p class="promotion-message">
            <?php
            $promos = [
                'Monday' => '2x1 en pizzas margarita',
                'Tuesday' => '50% de descuento en pizzas familiares',
                'Wednesday' => 'Pizza gratis al comprar una bebida grande',
                'Thursday' => 'Postre gratis con tu pedido',
                'Friday' => 'Envío gratis en pedidos mayores a $1000',
                'Saturday' => '3x2 en pizzas clásicas',
                'Sunday' => 'Combo familiar con descuento del 20%',
            ];
            $today = date('l');
            $promotionMessage = array_key_exists($today, $promos) ? $promos[$today] : 'No hay promociones para hoy.';
            echo $promotionMessage;
            ?>
        </p>
    </div>

    <div class="main-content">
        <h2 class="animate__animated animate__backInLeft">NUESTRAS PIZZAS</h2>
        <div id="cart">
            <i class="fa badge" id="badge" value=0><i class="fa-solid fa-cart-shopping fa-lg"></i></i>
        </div>
        <form accept-charset="utf-8" method="get">
        <div id="search-container">          
            <input type="search" size="30" placeholder="Descripción del producto..." id="search-input" name="search-input">
            <button id="search" name="search">Buscar</button>
        </div>
        </form>
        <ul class="gallery">
            <?php 
            include_once("config_products.php");
            include_once("db.class.php");
            $link = new Db();
            $search = isset($_GET['search-input']) ? $_GET['search-input'] : '';
            if (isset($_GET['search'])) {
                $sql = "SELECT c.category_name, p.image, p.product_name, p.price, DATE_FORMAT(p.start_date,'%d/%m/%Y') as date 
                        FROM products p 
                        INNER JOIN categories c ON p.id_category = c.id_category  
                        WHERE product_name LIKE CONCAT ('%', '$search', '%') OR category_name LIKE CONCAT('%', '$search', '%') 
                        ORDER BY p.price";
            } else {
                $sql = "SELECT c.category_name, p.image, p.product_name, p.price, DATE_FORMAT(p.start_date,'%d/%m/%Y') as DATE 
                        FROM products p 
                        INNER JOIN categories c ON p.id_category = c.id_category  
                        ORDER BY p.price";
            }
            
            $stmt = $link->run($sql, NULL);
            if ($stmt->rowCount() == 0) {
                echo "No hay resultados";
            } else {
                echo "Se han encontrado " . $stmt->rowCount() . " resultados";
            }
            
            $data = $stmt->fetchAll();
            try {
                $conn = new PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, PASSWORD);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll();
            } catch (PDOException $e) {
                echo "¡Error!: ";
                die();
            }
            
            foreach ($data as $row) {
            ?>
            <li>
                <div class="card">
                    <figure> 
                        <img src="<?php echo $row['image']?>" class="img-jpg" alt="fugazzeta" />
                        <figcaption>
                            <h3><?php echo $row['category_name'] . " " . $row['product_name']?></h3>
                            <p><?php echo "$" . " " . $row['price']?></p>
                            <time><?php echo $row['DATE']?></time>
                        </figcaption>
                        <button class="button" value="1">
                            Añadir al carrito <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                    </figure>
                </div>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>

    <footer>
        <p>Copyright &copy; <script> document.write(new Date().getFullYear()); </script> Todos los derechos reservados</p>
    </footer>

    <nav id="social">
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-square-instagram"></i></a>
    </nav>

    <script></script>
    <script src="js/main.js"></script>
</body>

</html>
