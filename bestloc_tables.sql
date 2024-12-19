use bestloc;

CREATE TABLE contract (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    vehicule_uid VARCHAR(255) NOT NULL,
    customer_uid VARCHAR(255) NOT NULL,
    sign_date DATETIME NOT NULL,
    loc_begin_date DATETIME,
    loc_end_date DATETIME,
    returning_date DATETIME,
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