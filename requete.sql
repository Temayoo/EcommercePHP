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


-- Insertion des produits
INSERT INTO Produit (stock, prix, genre, nom, commentaire) VALUES
(10, 1009.99, 'Électronique', 'Télephone', 'Un excellent Télephone avec de nombreuses fonctionnalités.'),
(20, 49.99, 'Vêtements', 'Chemise ', 'Chemise pour occasions spéciales.'),
(15, 99.99, 'Électroménager', 'Cafetière automatique', 'Préparez votre café préféré.'),
(5, 199.99, 'Informatique', 'Ordinateur portable', 'Puissant et portable pour répondre à tous vos besoins.'),
(30, 14.99, 'Livres', 'Roman captivant', 'Un passionnant roman.'),
(30, 14.99, 'Livres', 'Pomme le livre ', 'Un passionnant roman.');


-- Insertion de l'utilisateur "user" - useruser
INSERT INTO User (email, mdp, pseudo) VALUES
('user@gmail.com', 'e172c5654dbc12d78ce1850a4f7956ba6e5a3d2ac40f0925fc6d691ebb54f6bf', 'user');

-- Insertion de l'utilisateur "admin" -adminadmin
INSERT INTO User (email, mdp, pseudo, admin) VALUES
('admin@gmail.com', 'd82494f05d6917ba02f7aaa29689ccb444bb73f20380876cb05d1f37537b7892', 'admin', TRUE);


-- Insertion des commentaire
INSERT INTO commentaire (id_user, id_produit, commentaire, notations) VALUES
(2, 2, "Sous vétement de merde", 0.0),
(1, 2, "Franchement, pas mal", 6.0);

AlTER TABLE Commande ADD status VARCHAR(255);