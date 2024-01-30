-- Création de la table User
CREATE TABLE User (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    pseudo VARCHAR(255) NOT NULL,
    admin BOOLEAN DEFAULT FALSE,
    creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    action TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Création de la table Produit
CREATE TABLE Produit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    stock INT,
    prix FLOAT,
    genre VARCHAR(255),
    nom VARCHAR(255),
    commentaire TEXT,
    notations FLOAT
);


-- Création de la table Commande
CREATE TABLE Commande (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    id_produit INT,
    date_commande DATE,
    description TEXT,
    FOREIGN KEY (id_user) REFERENCES User(id),
    FOREIGN KEY (id_produit) REFERENCES Produit(id)
);


-- Création de la table de liaison ProduitCommande
CREATE TABLE ProduitCommande (
    id_produit INT,
    id_commande INT,
    quantite INT,
    FOREIGN KEY (id_produit) REFERENCES Produit(id),
    FOREIGN KEY (id_commande) REFERENCES Commande(id)
);


-- Insertion des produits
INSERT INTO Produit (stock, prix, genre, nom, commentaire, notations) VALUES
(10, 1009.99, 'Électronique', 'Télephone', 'Un excellent Télephone avec de nombreuses fonctionnalités.', 4.5),
(20, 49.99, 'Vêtements', 'Chemise ', 'Chemise pour occasions spéciales.', 4.2),
(15, 99.99, 'Électroménager', 'Cafetière automatique', 'Préparez votre café préféré.', 4.0),
(5, 199.99, 'Informatique', 'Ordinateur portable', 'Puissant et portable pour répondre à tous vos besoins.', 4.8),
(30, 14.99, 'Livres', 'Roman captivant', 'Un passionnant roman.', 4.6);
