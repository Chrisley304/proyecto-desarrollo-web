USE siafi_website;
-- ADMINS
INSERT INTO admin_users (name, username, password)
VALUES ('Administrator', 'admin', 'admin');
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
        'SIAFI Website',
        'SIAFI',
        'https://i.imgur.com/2X3X9Yw.png',
        'This is the official website of the SIAFI project. Here you can find information about the project, the team, the partners, the sponsors, the blogs, the projects, and the contact form.',
        'SIAFI Team',
        'https://i.imgur.com/2X3X9Yw.png'
    );