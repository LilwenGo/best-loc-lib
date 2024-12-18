use bestloc;

CREATE TABLE contract (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    vehicule_uid VARCHAR(255) NOT NULL,
    customer_uid VARCHAR(255) NOT NULL,
    sign_date DATETIME NOT NULL,
    loc_begin_date DATETIME NOT NULL,
    loc_end_date DATETIME NOT NULL,
    returning_date DATETIME NOT NULL,
    price DECIMAL(10,4) NOT NULL
)ENGINE=InnoDB;

CREATE TABLE billing (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    contract_id INT NOT NULL,
    amount DECIMAL(10,4) NOT NULL,
    CONSTRAINT fk_billing_contract_id 
    FOREIGN KEY (contract_id)
    REFERENCES contract (id)
    ON UPDATE restrict
    ON DELETE cascade
)ENGINE=InnoDB;