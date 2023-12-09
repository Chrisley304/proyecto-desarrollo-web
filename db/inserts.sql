USE siafi_website;
-- ADMINS
INSERT INTO admin_users (name, username, password)
VALUES ('Administrador', 'admin', 'admin');
-- BLOGS
INSERT INTO blogs (
        title,
        category,
        cover_image,
        description,
        author_name,
        author_photo
    )
VALUES (
        'SIAFI Web',
        'SIAFI',
        'https://i.imgur.com/2X3X9Yw.png',
        'Esta es la página web oficial del proyecto SIAFI. Aquí puedes encontrar información sobre el proyecto, el equipo, los socios, los patrocinadores, los blogs, los proyectos y el formulario de contacto.',
        'SIAFI Equipo',
        'https://i.imgur.com/2X3X9Yw.png'
    );
-- Contact form entries
INSERT INTO contact_form_entries (name, email, description)
VALUES (
        'John Doe',
        'john@mail.com',
        'Mensaje de prueba'
    );