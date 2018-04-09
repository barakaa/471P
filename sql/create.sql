DROP TABLE IF EXISTS maintenance_roster;
DROP TABLE IF EXISTS maintenance;
DROP TABLE IF EXISTS unpowered;
DROP TABLE IF EXISTS trainer;
DROP TABLE IF EXISTS rental;
DROP TABLE IF EXISTS payment_method;
DROP TABLE IF EXISTS participant;
DROP TABLE IF EXISTS powered;
DROP TABLE IF EXISTS training_camp;
DROP TABLE IF EXISTS equipment;
DROP TABLE IF EXISTS location;
DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS client;

CREATE TABLE client (
    username VARCHAR(30) NOT NULL,
    cl_pass VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    PRIMARY KEY (USERNAME)
);

CREATE TABLE customer (
    username VARCHAR(30) NOT NULL,
    data_account_created DATE NOT NULL,
    PRIMARY KEY (username),
    FOREIGN KEY (username) REFERENCES client (username)
	ON DELETE CASCADE
);

CREATE TABLE employee (
    username VARCHAR(30) NOT NULL,
    can_train INT NOT NULL,
    can_repair INT NOT NULL,
    salary INT NOT NULL,
    date_hired DATE NOT NULL,
    PRIMARY KEY (username),
    FOREIGN KEY (username) REFERENCES client (username)
	ON DELETE CASCADE
);

CREATE TABLE location (
    name VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    address VARCHAR(255) NOT NULL,
    PRIMARY KEY (name)
);

CREATE TABLE equipment (
    equip_id INT NOT NULL AUTO_INCREMENT,
    price_per_day INT NOT NULL,
    weight INT,
    status CHAR(1),
    loc_name VARCHAR(255),
    PRIMARY KEY (equip_id),
    FOREIGN KEY (loc_name) REFERENCES location (name)
        ON DELETE CASCADE
);

CREATE TABLE training_camp (
    equip_id INT NOT NULL,
    camp_id CHAR(10) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    CONSTRAINT pk_training_camp PRIMARY KEY (equip_id, camp_id),
    FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
        ON DELETE CASCADE
);

CREATE TABLE maintenance (
    start_date DATE NOT NULL,
    equip_id INT NOT NULL,
    finish_date DATE,
    cost INT NOT NULL,
    PRIMARY KEY (start_date, equip_id),
    FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
        ON DELETE CASCADE
);

CREATE TABLE maintenance_roster (
    emp_username VARCHAR(30) NOT NULL,
    start_date DATE NOT NULL,
    equip_id INT,
    PRIMARY KEY (emp_username, start_date, equip_id),
    CONSTRAINT maintenance_roster_fk1 FOREIGN KEY (emp_username) REFERENCES employee (username)
        ON DELETE CASCADE,
    CONSTRAINT maintenance_roster_fk2 FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
        ON DELETE CASCADE
);

CREATE TABLE powered (
    equip_id INT NOT NULL,
    fuel_type VARCHAR(10),
    fuel_economy VARCHAR(10), -- double check type
    cargo_capacity INT,
    occupant_capacity INT,
    PRIMARY KEY (equip_id),
    FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
        ON DELETE CASCADE
);

CREATE TABLE payment_method (
    payment_type VARCHAR(10) NOT NULL,
    emp_username VARCHAR(30) NOT NULL,
    cust_username VARCHAR(30) NOT NULL,
    available_balance INT NOT NULL,
    PRIMARY KEY (payment_type, emp_username, cust_username, available_balance),
    CONSTRAINT payment_method_fk1 FOREIGN KEY (emp_username) REFERENCES employee (username)
        ON DELETE CASCADE,
    CONSTRAINT payment_method_fk2 FOREIGN KEY (cust_username) REFERENCES customer (username)
        ON DELETE CASCADE
);

CREATE TABLE rental (
    equip_id INT NOT NULL,
    cust_username VARCHAR(30) NOT NULL,
    start_date DATE NOT NULL,
    return_date DATE NOT NULL,
    insurance_payment VARCHAR(255),
    insurance_coverage VARCHAR(255),
    PRIMARY KEY (start_date, cust_username, equip_id),
    CONSTRAINT rental_fk1 FOREIGN KEY (cust_username) REFERENCES customer (username)
        ON DELETE CASCADE,
    CONSTRAINT rental_fk2 FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
        ON DELETE CASCADE
);

CREATE TABLE participant (
    equip_id INT NOT NULL,
    camp_id CHAR(10) NOT NULL,
    cust_username VARCHAR(30) NOT NULL,
    PRIMARY KEY (camp_id, cust_username),
    CONSTRAINT participant_fk1 FOREIGN KEY (equip_id, camp_id) REFERENCES training_camp (equip_id, camp_id)
        ON DELETE CASCADE,
    CONSTRAINT participant_fk2 FOREIGN KEY (cust_username) REFERENCES customer (username)
        ON DELETE CASCADE
);

CREATE TABLE trainer (
    equip_id INT NOT NULL,
    camp_id CHAR(10) NOT NULL,
    emp_username VARCHAR(30) NOT NULL,
    PRIMARY KEY (camp_id, emp_username),
    CONSTRAINT trainer_fk1 FOREIGN KEY (equip_id, camp_id) REFERENCES training_camp (equip_id, camp_id)
        ON DELETE CASCADE,
    CONSTRAINT trainer_fk2 FOREIGN KEY (emp_username) REFERENCES employee (username)
        ON DELETE CASCADE
);


CREATE TABLE unpowered (
    equip_id INT NOT NULL,
    intended_use VARCHAR(255),
    insurance_required CHAR(1) NOT NULL,
    PRIMARY KEY (equip_id),
    FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
        ON DELETE CASCADE
);
