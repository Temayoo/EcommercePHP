-- Création de la table User
CREATE TABLE User (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    pseudo VARCHAR(255) NOT NULL,
    admin BOOLEAN DEFAULT FALSE,
    creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    action TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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

