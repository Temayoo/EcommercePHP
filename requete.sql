-- Création de la table User
CREATE TABLE User (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    pseudo VARCHAR(255) NOT NULL,
    admin BOOLEAN DEFAULT FALSE,
    creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    action TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB CHARSET=utf8mb4;



-- Création de la table Produit
CREATE TABLE Produit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    stock INT,
    prix FLOAT,
    genre VARCHAR(255),
    nom VARCHAR(255),
    commentaire TEXT,
    image_url VARCHAR(255)
)engine=InnoDB CHARSET=utf8mb4;


-- Création de la table Commande
CREATE TABLE Commande (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_update TIMESTAMP,
    status VARCHAR(255),
    detail TEXT,
    FOREIGN KEY (id_user) REFERENCES User(id)
)engine=InnoDB CHARSET=utf8mb4;

-- Création de la table Commentaire
CREATE TABLE commentaire (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user int,
    id_produit int,
    commentaire TEXT,
    notations FLOAT,
    FOREIGN KEY (id_user) REFERENCES User(id),
    FOREIGN KEY (id_produit) REFERENCES Produit(id)
)engine=InnoDB CHARSET=utf8mb4;


-- Création de la table de liaison ProduitCommande
CREATE TABLE ProduitCommande (
    id_produit INT,
    id_commande INT,
    quantite INT,
    FOREIGN KEY (id_produit) REFERENCES Produit(id),
    FOREIGN KEY (id_commande) REFERENCES Commande(id)
)engine=InnoDB CHARSET=utf8mb4;


-- Création de la table Localisation
CREATE TABLE Localisation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    adresse VARCHAR(255),
    code_postal VARCHAR(10),
    ville VARCHAR(255),
    pays VARCHAR(255),
    FOREIGN KEY (id_user) REFERENCES User(id)
)engine=InnoDB CHARSET=utf8mb4;


-- Insertion des produits sur le thème des plantes
INSERT INTO Produit (stock, prix, genre, nom, commentaire, image_url) VALUES
(15, 29.99, "Plantes d'intérieur", "Fougère d'intérieur", "Une fougère élégante pour décorer votre espace intérieur.", "https://magazine.hortus-focus.fr/wp-content/uploads/sites/2/2021/11/nephrolepis-exaltata-benoitbruchez-1200x800-1.jpg"),
(10, 19.99, "Plantes d'extérieur", "Rosier coloré", "Des roses éclatantes pour embellir votre jardin.", "https://media.ooreka.fr/public/image/Intro-plante-rose-fuchsia-ciel-nuage-bougainvilliers-jardin-printemps-soleil-full-12304060.jpg"),
(25, 39.99, "Plantes médicinales", "Lavande apaisante", "La lavande pour ses propriétés apaisantes et son parfum relaxant.", "https://www.senteursduquercy.com/7102-thickbox/lavandula-angustifolia-spear-blue-vraie-lavande-bleu-violet.jpg"),
(8, 49.99, "Cactus", "Cactus résistant", "Un cactus facile d'entretien pour ajouter une touche désertique à votre collection.", "https://www.foliflora.fr/static/photos/cactus-1.jpg"),
(12, 24.99, "Herbes aromatiques", "Basilic frais", "Le basilic pour parfumer vos plats avec une saveur délicieuse.", "https://img-3.journaldesfemmes.fr/QLjwn9862lI6cTEm-cSD-cSM0MI=/1500x/smart/b08a3b2dea9e4b088b747c15ea27e8dd/ccmcms-jdf/24762816.jpg");


-- Insertion de l'utilisateur "user" - useruser
INSERT INTO User (email, mdp, pseudo) VALUES
('user@gmail.com', 'e172c5654dbc12d78ce1850a4f7956ba6e5a3d2ac40f0925fc6d691ebb54f6bf', 'user');

-- Insertion de l'utilisateur "admin" -adminadmin
INSERT INTO User (email, mdp, pseudo, admin) VALUES
('admin@gmail.com', 'd82494f05d6917ba02f7aaa29689ccb444bb73f20380876cb05d1f37537b7892', 'admin', TRUE);


-- Insertion des commentaires sur les plantes
INSERT INTO commentaire (id_user, id_produit, commentaire, notations) VALUES
(2, 1, 'La fougère est magnifique, elle donne une ambiance apaisante à la maison.', 8.0),
(1, 3, "La lavande a un parfum incroyable, je l'adore dans mon jardin.", 9.5),
(2, 4, 'Le cactus est vraiment résistant, parfait pour les personnes sans main verte.', 7.5);

