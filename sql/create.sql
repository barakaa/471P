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
);

CREATE TABLE employee (
    username VARCHAR(30) NOT NULL,
    can_train INT NOT NULL, -- double check type
    can_repair INT NOT NULL, -- double check type
    salary INT NOT NULL,
    date_hired DATE NOT NULL,
    PRIMARY KEY (username),
    FOREIGN KEY (username) REFERENCES client (username)
);

CREATE TABLE location (
    name VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    address VARCHAR(255) NOT NULL,
    PRIMARY KEY (name)
);

CREATE TABLE equipment (
    equip_id NUMERIC(7) NOT NULL,
    price_per_day INT NOT NULL,
    weight INT,
    status CHAR(1),
    loc_name VARCHAR(255),
    PRIMARY KEY (equip_id),
    FOREIGN KEY (loc_name) REFERENCES location (name)
);

CREATE TABLE training_camp (
    equip_id NUMERIC(7) NOT NULL,
    camp_id CHAR(10) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    CONSTRAINT pk_training_camp PRIMARY KEY (equip_id, camp_id),
    FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
);

CREATE TABLE maintenance (
    start_date DATE NOT NULL,
    equip_id NUMERIC(7) NOT NULL,
    finish_data DATE,
    cost INT NOT NULL,
    PRIMARY KEY (start_date, equip_id),
    FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
);

CREATE TABLE maintenance_roster (
    emp_username VARCHAR(30) NOT NULL,
    start_date DATE NOT NULL,
    equip_id NUMERIC(7),
    PRIMARY KEY (emp_username, start_date, equip_id),
    CONSTRAINT maintenance_roster_fk1 FOREIGN KEY (emp_username) REFERENCES employee (username),
    CONSTRAINT maintenance_roster_fk2 FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
);

CREATE TABLE powered (
    equip_id NUMERIC(7) NOT NULL,
    fuel_type VARCHAR(10),
    fuel_economy VARCHAR(10), -- double check type
    cargo_capacity INT,
    occupant_capacity INT,
    PRIMARY KEY (equip_id),
    FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
);

CREATE TABLE payment_method (
    payment_type VARCHAR(10) NOT NULL, -- double check type
    emp_username VARCHAR(30) NOT NULL,
    cust_username VARCHAR(30) NOT NULL,
    available_balance INT NOT NULL,
    PRIMARY KEY (payment_type, emp_username, cust_username, available_balance),
    CONSTRAINT payment_method_fk1 FOREIGN KEY (emp_username) REFERENCES employee (username),
    CONSTRAINT payment_method_fk2 FOREIGN KEY (cust_username) REFERENCES customer (username)
);

CREATE TABLE rental (
    equip_id NUMERIC(7) NOT NULL,
    cust_username VARCHAR(30) NOT NULL,
    start_date DATE NOT NULL,
    return_date DATE NOT NULL,
    insurance_payment VARCHAR(255),
    insurance_coverage VARCHAR(255),
    PRIMARY KEY (start_date, cust_username, equip_id),
    CONSTRAINT rental_fk1 FOREIGN KEY (cust_username) REFERENCES customer (username),
    CONSTRAINT rental_fk2 FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
);

CREATE TABLE participant (
    equip_id NUMERIC(7) NOT NULL,
    camp_id CHAR(10) NOT NULL,
    cust_username VARCHAR(30) NOT NULL,
    PRIMARY KEY (camp_id, cust_username),
    CONSTRAINT participant_fk1 FOREIGN KEY (equip_id, camp_id) REFERENCES training_camp (equip_id, camp_id),
    CONSTRAINT participant_fk2 FOREIGN KEY (cust_username) REFERENCES customer (username)
);

CREATE TABLE trainer (
    equip_id NUMERIC(7) NOT NULL,
    camp_id CHAR(10) NOT NULL,
    emp_username VARCHAR(30) NOT NULL,
    PRIMARY KEY (camp_id, emp_username),
    CONSTRAINT trainer_fk1 FOREIGN KEY (equip_id, camp_id) REFERENCES training_camp (equip_id, camp_id),
    CONSTRAINT trainer_fk2 FOREIGN KEY (emp_username) REFERENCES employee (username)
);


CREATE TABLE unpowered (
    equip_id NUMERIC(7) NOT NULL,
    intended_use VARCHAR(255),
    insurance_required CHAR(1) NOT NULL, -- double check type
    PRIMARY KEY (equip_id),
    FOREIGN KEY (equip_id) REFERENCES equipment (equip_id)
);

INSERT INTO client VALUES ('admin', '$2y$10$TDSKb.2EYM9bnwC1hXT9I.nN19kEw4IrA.v3UDwv30t720UsHawNC', '2018-03-29');
INSERT INTO employee VALUES ('admin', 0, 0, 0, '2018-03-29');
