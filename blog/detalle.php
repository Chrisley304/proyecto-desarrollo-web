<?php
include("../api/db.php"); // Include your database connection file

// Get the blog ID from the URL
if (isset($_GET['id'])) {
    $blogId = $_GET['id'];

    // Fetch the blog details from the database
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $blogId);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="../styles/navbar.css" />
    <link rel="stylesheet" href="../styles/blog-card.css" />
    <link rel="stylesheet" href="../styles/globals.css" />
    <link rel="stylesheet" href="../styles/footer.css" />
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="../assets/fonts/HelveticaNowDisplay/font.css" />
    <title><?php echo $blog['title']; ?> - SIAFI</title>
    <meta name="description" content="Bienvenido a la página de la Sociedad de Inteligencia Artificial de la Facultad de Ingeniería - SIAFI" />
</head>
<style>
    #blog_content {
        font-size: 18px;
    }

    .blog_header {
        background: white;
        display: flex;
        gap: 2rem;
        align-items: center;
        padding: 41px 123px;
    }

    .blog_header_img {
        border-radius: var(--radius-m, 12px);
        max-width: 600px;
    }

    .blog_header_info {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .blog_header_category,
    .blog_header_date {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        align-self: stretch;
        overflow: hidden;
        color: #6d6d6d;
        text-overflow: ellipsis;
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: 110%;
        /* 22px */
        letter-spacing: -0.4px;
    }

    /* Estilos base */
    .navbar_container {
        display: flex;
        justify-content: space-between;
        position: sticky;
        align-items: center;
        background-color: transparent;
        color: #000;
        /* Letras negras */
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .navbar_links {
        list-style: none;
        display: flex;
    }

    .navbar_links li {
        margin-right: 20px;
    }

    .navbar_links a {
        text-decoration: none;
        color: #000;
        /* Letras negras */
        font-weight: bold;
    }

    /* Botón para dispositivos pequeños */
    .navbar_toggler {
        display: none;
    }

    /* Estilos adicionales cuando la barra es fija en la parte superior */
    .navbar_container.fixed-top {
        background-color: transparent;
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 1000;
        /* Ajusta según sea necesario */
        color: #000;
        /* Letras negras */
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Estilos para la lista de enlaces en dispositivos pequeños */
    @media only screen and (max-width: 768px) {
        .navbar_links {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 70px;
            /* Ajusta según la altura de tu barra de navegación */
            left: 0;
            width: 100%;
            background-color: #fff;
            /* Fondo blanco */
            padding: 10px;
        }

        .navbar_links.show {
            display: flex;
        }

        .navbar_toggler {
            display: block;
            /* Asegúrate de que esté visible en dispositivos pequeños */
        }
    }

    footer {
        /* Color de fondo del footer */
        color: #fff;
        /* Color del texto del footer */
    }

    .footer_content {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        text-align: center;
        /* Alineación centrada para todo el contenido */
    }

    /* Ajustes para dispositivos pequeños */
    @media only screen and (max-width: 768px) {
        .footer_links_list {
            width: 100%;
            margin-top: 20px;
        }

        .footer_links_list ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .footer_links_list li {
            width: 48%;
            /* Dos columnas con un pequeño espacio entre ellas */
            margin-bottom: 10px;
        }
    }

    .footer_socials {
        margin: 0 auto;
        /* Centra elementos internos */
        max-width: 300px;
        /* Ajusta según sea necesario */
    }

    /* Estilo para el aviso de copyright */
    footer a {
        margin: 0 auto;
        /* Centra elementos internos */
        max-width: 300px;
        /* Ajusta según sea necesario */
        text-align: center;
        /* Alineación centrada para el aviso de copyright */
    }

    /* Estilo para el aviso de copyright */
    footer a {
        display: block;
        margin-top: 20px;
    }
</style>

<body>
    <!-- Navbar (components/navbar) -->
    <nav class="navbar_container">
        <div class="navbar_logo">
            <a href="/">
                <img src="../assets/img/logos/siafi-logo.svg" alt="SIAFI Logo" width="117" />
            </a>
        </div>
        <ul class="navbar_links" id="navbarLinks">
            <li><a href="/#nosotros">Nosotros</a></li>
            <li><a href="/proyectos/">Proyectos</a></li>
            <li><a href="/blog/" class="active">Blog</a></li>
            <li><a href="/contacto/">Contacto</a></li>
        </ul>
        <button class="navbar_toggler" id="navbarToggler">
            <img src="../assets/img/logos/menu.svg" alt="Toggle Menu" />
        </button>
    </nav>
    <header class="blog_header">
        <img class="blog_header_img" src="data:image/jpeg;base64,<?php echo base64_encode($blog['cover_image']); ?>" alt="Cover Image" />
        <div class="blog_header_info">
            <p class="blog_header_category"><?php echo $blog['category']; ?></p>
            <h2><?php echo $blog['title']; ?></h2>
            <div class="blog_card_author">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($blog['author_photo']); ?>" alt="Cover Image" />
                <p><b>Autor: </b> <?php echo $blog['author_name']; ?></p>
            </div>
            <!-- <p class="blog_header_date">Fecha</p> -->
        </div>
    </header>
    <section id="blog_content">

        <?php if (isset($blog)) : ?>
            <p class="contact_text">
                <?php echo $blog['description']; ?>
            </p>
        <?php else : ?>
            <p class="contact_text">Blog no encontrado.</p>
        <?php endif; ?>
    </section>

    <!-- Footer (components/footer) -->
    <footer>
        <div class="footer_content">
            <!-- First column -->
            <div>
                <a href="/">
                    <img src="../assets/img/logos/siafi-logo-white.png" alt="SIAFI logo white" class="footer_logo" />
                </a>
                <!-- Social media links -->
                <div class="footer_socials">
                    <a href="https://www.instagram.com/unam.siafi/" target="_blank">
                        <img src="../assets/img/footer/instagram-bubble.svg" alt="Instagram" />
                    </a>
                    <a href="https://www.facebook.com/UNAM.SIAFI" target="_blank">
                        <img src="../assets/img/footer/facebook-bubble.svg" alt="Facebook" />
                    </a>
                    <a href="https://www.linkedin.com/company/siafiunam/" target="_blank">
                        <img src="../assets/img/footer/linkedin-bubble.svg" alt="LinkedIn" />
                    </a>
                    <a href="https://www.tiktok.com/@unam.siafi" target="_blank">
                        <img src="../assets/img/footer/tiktok-logo.svg" alt="TikTok" />
                    </a>
                    <a href="https://www.youtube.com/c/SIAFIUNAM" target="_blank">
                        <img src="../assets/img/footer/youtube-bubble.svg" alt="TikTok" />
                    </a>
                </div>
                <div class="footer_direction">
                    <h4>Dirección</h4>
                    <p>
                        Edificio CIA, 4to piso, conjunto sur, Circuito
                        interior 3000 Col. Universidad Nacional Autónoma de
                        México Coyoacán, C.P. 04510 Ciudad de México, México
                    </p>
                </div>
            </div>
            <!-- Second Column -->
            <div></div>
            <!-- Third Column -->
            <div class="footer_links_list">
                <h4>Contacto</h4>
                <ul>
                    <li>
                        <a href="mailto:contacto@siafi-unam.org">contacto@siafi-unam.org</a>
                    </li>
                </ul>
            </div>
            <!-- Fourth Column -->
            <div class="footer_links_list">
                <h4>Navegación</h4>
                <ul>
                    <li><a href="/#nosotros">Nosotros</a></li>
                    <li><a href="/proyectos/">Proyectos</a></li>
                    <!-- <li><a href="/eventos/">Eventos</a></li> -->
                    <li><a href="/blog/">Blog</a></li>
                    <li><a href="/contacto/">Contacto</a></li>
                </ul>
            </div>
            <!-- Fifth Column -->
            <div class="footer_links_list footer_logos">
                <h4>Instituciones</h4>
                <ul>
                    <li>
                        <a href="https://www.ingenieria.unam.mx/dimei/" target="_blank"><img src="../assets/img/logos/dimei-logo.png" alt="DIMEI" /></a>
                    </li>
                    <li>
                        <a href="https://www.ingenieria.unam.mx/cia/" target="_blank"><img src="../assets/img/logos/cia-logo.png" alt="CIA" /></a>
                    </li>
                    <li>
                        <a href="https://www.ingenieria.unam.mx/" target="_blank"><img src="../assets/img/logos/fi-logo.png" alt="Facultad de Ingeniería" /></a>
                    </li>
                    <li>© SIAFI 2024. México</li>
                </ul>
            </div>
        </div>
        <a>© SIAFI 2024. México</a>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navbarLinks = document.getElementById("navbarLinks");
            const navbarToggler = document.getElementById("navbarToggler");

            navbarToggler.addEventListener("click", function() {
                navbarLinks.classList.toggle("show");
            });

            // Añadir clase "fixed-top" al hacer scroll hacia abajo
            window.addEventListener("scroll", function() {
                const scrollY = window.scrollY || window.pageYOffset;

                if (scrollY > 0) {
                    document
                        .querySelector(".navbar_container")
                        .classList.add("fixed-top");
                } else {
                    document
                        .querySelector(".navbar_container")
                        .classList.remove("fixed-top");
                }
            });
        });
    </script>
</body>

</html>