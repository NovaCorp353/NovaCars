import java.sql.*;
import java.util.logging.Level;
import java.util.logging.Logger;

public class Main {

    public static void main(String[] args) {


        // TODO TO BE CHANGED
        final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
        final String URL = "jdbc:mysql://localhost/project";
        final String USER = "root";
        final String PASS = "";

        try {
            Class.forName(JDBC_DRIVER);
        } catch (ClassNotFoundException e) {
            System.out.println("Library file not found!");
            System.exit(-1);
        }

        try (Connection connection = DriverManager.getConnection(URL, USER, PASS);
             Statement statement = connection.createStatement()) {

            System.out.println("Connection established.");

            //TABLE CREATION
            System.out.println("Creating tables...");

            //DROP TABLES
//            statement.executeUpdate("DROP TABLE IF EXISTS User;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Customer;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Auto;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Department;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Employee;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Clerk;");
//            statement.executeUpdate("DROP TABLE IF EXISTS SalesManager;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Technician;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Manager;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Supplier;");
//            statement.executeUpdate("DROP TABLE IF EXISTS SparePart;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Supply;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Operation;");
//            statement.executeUpdate("DROP TABLE IF EXISTS Transaction;");
//            statement.executeUpdate("DROP TABLE IF EXISTS TechnicianOperation;");
//            statement.executeUpdate("DROP TABLE IF EXISTS SparePartOrder;");
//            statement.executeUpdate("DROP TABLE IF EXISTS CustomerOperation;");


            //RECREATE TABLES

            //User
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS User( " +
                    "email VARCHAR(50) NOT NULL, " +
                    "password VARCHAR(20) NOT NULL, " +
                    "first_name VARCHAR(20) NOT NULL, " +
                    "last_name VARCHAR(20) NOT NULL, " +
                    "PRIMARY KEY (email) " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table User... done!");

            //Customer
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Customer( " +
                    "email VARCHAR(50) NOT NULL, " +
                    "membership_sts VARCHAR(20) NOT NULL, " +
                    "bonus_pts NUMERIC(5,0), " +
                    "PRIMARY KEY (email), " +
                    "FOREIGN KEY (email) REFERENCES User(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Customer... done!");

            //Auto
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Auto( " +
                    "plate VARCHAR(10) NOT NULL, " +
                    "model VARCHAR(15), " +
                    "year YEAR(4), " +
                    "customer_email VARCHAR(50) NOT NULL, " +
                    "PRIMARY KEY (plate), " +
                    "FOREIGN KEY (customer_email) REFERENCES Customer(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Auto... done!");

            //Department
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Department( " +
                    "name VARCHAR(30) NOT NULL, " +
                    "budget     NUMERIC(12,2), " +
                    "expenditure NUMERIC(12,2), " +
                    "PRIMARY KEY (name) " +
                    ") " +
                    "ENGINE = INNODB; ");
            System.out.println("Table Department... done!");

            //Employee
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Employee( " +
                    "email VARCHAR(50) NOT NULL, " +
                    "salary NUMERIC(10,2) NOT NULL, " +
                    "expertise_lvl NUMERIC(2,0), " +
                    "dept_name  VARCHAR(30) NOT NULL, " +
                    "since YEAR(4) NOT NULL, " +
                    "PRIMARY KEY(email), " +
                    "FOREIGN KEY(email) REFERENCES User(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(dept_name) REFERENCES Department(name) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Employee... done!");

            //Clerk
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Clerk ( " +
                    "email      VARCHAR(50) NOT NULL, " +
                    "PRIMARY KEY(email), " +
                    "FOREIGN KEY(email) REFERENCES Employee (email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Clerk... done!");

            //Sales Manager
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS SalesManager ( " +
                    "email VARCHAR(50) NOT NULL, " +
                    "PRIMARY KEY(email), " +
                    "FOREIGN KEY(email) REFERENCES Employee(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB; ");
            System.out.println("Table SalesManager... done!");

            //Technician
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Technician( " +
                    "email VARCHAR(50) NOT NULL, " +
                    "PRIMARY KEY(email), " +
                    "FOREIGN KEY(email) REFERENCES Employee(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Technician... done!");

            //Manager
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Manager ( " +
                    "email VARCHAR(50) NOT NULL, " +
                    "start_date YEAR(4), " +
                    "PRIMARY KEY(email),  " +
                    "FOREIGN KEY(email) REFERENCES Employee(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Manager... done!");

            //Supplier
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Supplier( " +
                    "name VARCHAR(30) NOT NULL, " +
                    "phone VARCHAR(12), " +
                    "address VARCHAR(60), " +
                    "contact_name VARCHAR(20) NOT NULL, " +
                    "PRIMARY KEY(name) " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Supplier... done!");

            //Spare Parts
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS SparePart( " +
                    "type VARCHAR(15) NOT NULL, " +
                    "model VARCHAR(10) NOT NULL, " +
                    "stock_quantity     SMALLINT,  " +
                    "price      NUMERIC(10,2) NOT NULL, " +
                    "PRIMARY KEY(type, model) " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table SparePart... done!");

            //Supply
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Supply( " +
                    "type VARCHAR(15) NOT NULL, " +
                    "model VARCHAR(10) NOT NULL, " +
                    "supplier_name VARCHAR(30) NOT NULL, " +
                    "PRIMARY KEY(type, model, supplier_name), " +
                    "FOREIGN KEY(type, model) REFERENCES SparePart(type, model) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(supplier_name) REFERENCES Supplier(name) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Supply... done!");

            //Operation
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Operation( " +
                    "dept_name VARCHAR(30) NOT NULL, " +
                    "op_name VARCHAR(30) NOT NULL, " +
                    "cost NUMERIC(8,2), " +
                    "sparepart_type VARCHAR(15), " +
                    "sparepart_model VARCHAR(10), " +
                    "PRIMARY KEY(dept_name, op_name), " +
                    "FOREIGN KEY(dept_name) REFERENCES Department(name) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(sparepart_type, sparepart_model) REFERENCES Supply(type, model) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table Operation... done!");

            //Transaction
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS Transaction(" +
                    "id MEDIUMINT NOT NULL AUTO_INCREMENT, " +
                    "amount NUMERIC(7,2), " +
                    "date DATE, " +
                    "PRIMARY KEY (id) " +
                    ")  " +
                    "ENGINE = INNODB;");
            System.out.println("Table Transaction... done!");

            //Technician Operation
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS TechnicianOperation( " +
                    "dept_name VARCHAR(30) NOT NULL, " +
                    "op_name VARCHAR(30) NOT NULL, " +
                    "tech_email VARCHAR(50) NOT NULL, " +
                    "PRIMARY KEY (dept_name, op_name, tech_email), " +
                    "FOREIGN KEY(dept_name, op_name) REFERENCES Operation(dept_name, op_name) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(tech_email) REFERENCES Technician(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table TechnicianOperation... done!");

            //Spare Part Order
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS SparePartOrder( " +
                    "transaction_id MEDIUMINT NOT NULL, " +
                    "sales_mgr_email VARCHAR(50) NOT NULL, " +
                    "part_type VARCHAR(15) NOT NULL, " +
                    "part_model VARCHAR(10), " +
                    "supplier_name VARCHAR(30), " +
                    "count SMALLINT NOT NULL, " +
                    "PRIMARY KEY(transaction_id), " +
                    "FOREIGN KEY(transaction_id) REFERENCES Transaction(id) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(sales_mgr_email) REFERENCES SalesManager(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(supplier_name, part_type, part_model) REFERENCES Supply(supplier_name, type, model) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table SparePartOrder... done!");

            //Customer Operation
            statement.executeUpdate(
                    "CREATE TABLE IF NOT EXISTS CustomerOperation( " +
                    "transaction_id MEDIUMINT NOT NULL, " +
                    "dept_name VARCHAR(30) NOT NULL, " +
                    "op_name VARCHAR(30) NOT NULL, " +
                    "tech_email VARCHAR(50) NOT NULL, " +
                    "clerk_email VARCHAR(50) NOT NULL, " +
                    "customer_email     VARCHAR(50) NOT NULL, " +
                    "auto_plate VARCHAR(10) NOT NULL, " +
                    "PRIMARY KEY(transaction_id), " +
                    "FOREIGN KEY (transaction_id) REFERENCES Transaction(id) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(dept_name, op_name, tech_email) REFERENCES TechnicianOperation(dept_name, op_name, tech_email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(clerk_email) REFERENCES Clerk(email) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE, " +
                    "FOREIGN KEY(customer_email, auto_plate) REFERENCES Auto(customer_email, plate) " +
                    "ON DELETE CASCADE " +
                    "ON UPDATE CASCADE " +
                    ") " +
                    "ENGINE = INNODB;");
            System.out.println("Table CustomerOperation... done!");


            //TABLE POPULATION
            System.out.println("Inserting table population...");


            //Filling User Table
            statement.executeUpdate("INSERT INTO User VALUES ('onatkutd@novacorp.me','asd123','Onatkut','Dagtekin');");
            statement.executeUpdate("INSERT INTO User VALUES ('yasemind@novacorp.me','yasemelis','Yasemin','Doganci');");
            statement.executeUpdate("INSERT INTO User VALUES ('burcuc@novacorp.me','burcucan','Burcu','Canakci');");
            statement.executeUpdate("INSERT INTO User VALUES ('anik@novacorp.me','db123','Ani','Kristo');");
            statement.executeUpdate("INSERT INTO User VALUES ('besteekmekci@yahoo.com','nova','Beste','Ekmekci');");
            statement.executeUpdate("INSERT INTO User VALUES ('alexs@novacorp.me','kaptan','Alex','DeSouza');");
            statement.executeUpdate("INSERT INTO User VALUES ('mehmett@novacorp.me','mehmet123','Mehmet','Topal');");
            statement.executeUpdate("INSERT INTO User VALUES ('canerc@yahoo.com','erkin88','Caner','Erkin');");
            statement.executeUpdate("INSERT INTO User VALUES ('rustur@yahoo.com','turk9','Rustu','Recber');");
            statement.executeUpdate("INSERT INTO User VALUES ('lionelm@yahoo.com','fcb10','Lionel','Messi');");
            statement.executeUpdate("INSERT INTO User VALUES ('asild@novacorp.me','fish','Asil','Doganci');");

            statement.executeUpdate("INSERT INTO User VALUES ('arifu@bilkent.com','cs353','Arif','Usta');");
            statement.executeUpdate("INSERT INTO User VALUES ('ozguru@bilkent.com','teach','Ozgur','Ulusoy');");
            statement.executeUpdate("INSERT INTO User VALUES ('sahink@novacorp.me','ferrari','Sahin','Kuranel');");
            statement.executeUpdate("INSERT INTO User VALUES ('berkcang@gmail.com','dedeler','Berkcan','Gurel');");


            //Filling Customer Table
            statement.executeUpdate("INSERT INTO Customer VALUES ('arifu@bilkent.com','Elite',1000);");
            statement.executeUpdate("INSERT INTO Customer VALUES ('ozguru@bilkent.com','Elite',500);");
            statement.executeUpdate("INSERT INTO Customer VALUES ('asild@novacorp.me','Classic',0);");
            statement.executeUpdate("INSERT INTO Customer VALUES ('sahink@novacorp.me','Elite+',2000);");
            statement.executeUpdate("INSERT INTO Customer VALUES ('berkcang@gmail.com','Elite+',1500);");


            //Filling Auto Table
            statement.executeUpdate("INSERT INTO Auto VALUES ('06 CS 2012','Mercedes E250',2012,'arifu@bilkent.com');");
            statement.executeUpdate("INSERT INTO Auto VALUES ('06 DB 2016','BMW 525',2012,'ozguru@bilkent.com');");
            statement.executeUpdate("INSERT INTO Auto VALUES ('06 AVD 07','Opel Astra',2015,'asild@novacorp.me');");
            statement.executeUpdate("INSERT INTO Auto VALUES ('06 GNR 95','BMW 320',2009,'sahink@novacorp.me');");
            statement.executeUpdate("INSERT INTO Auto VALUES ('06 GG 2016','VW Polo',2013,'berkcang@gmail.com');");


            //Filling Department Table
            statement.executeUpdate("INSERT INTO Department VALUES ('Human Resources',20000,8000);");
            statement.executeUpdate("INSERT INTO Department VALUES ('Sales',50000,30000);");
            statement.executeUpdate("INSERT INTO Department VALUES ('Maintenance',30000,18000);");
            statement.executeUpdate("INSERT INTO Department VALUES ('Repair',20000,15000);");
            statement.executeUpdate("INSERT INTO Department VALUES ('Training',20000,10000);");


            //Filling Employee Table
            statement.executeUpdate("INSERT INTO Employee VALUES ('onatkutd@novacorp.me',5000,55,'Repair',2013);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('yasemind@novacorp.me',10000,65,'Maintenance',2009);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('burcuc@novacorp.me',20000,70,'Repair',2002);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('anik@novacorp.me',20000,80,'Sales',2000);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('besteekmekci@yahoo.com',1000,59,'Sales',2005);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('alexs@novacorp.me',5000,77,'Training',2005);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('mehmett@novacorp.me',2500,71,'Repair',2002);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('canerc@yahoo.com',14000,88,'Maintenance',2001);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('rustur@yahoo.com',24000,20,'Human Resources',2013);");
            statement.executeUpdate("INSERT INTO Employee VALUES ('lionelm@yahoo.com',34000,99,'Sales',2011);");


            //Filling Clerk Table
            statement.executeUpdate("INSERT INTO Clerk VALUES ('anik@novacorp.me');");


            //Filling SalesManager Table
            statement.executeUpdate("INSERT INTO SalesManager VALUES ('besteekmekci@yahoo.com');");


            //Filling Technician Table
            statement.executeUpdate("INSERT INTO Technician VALUES ('onatkutd@novacorp.me');");
            statement.executeUpdate("INSERT INTO Technician VALUES ('yasemind@novacorp.me');");
            statement.executeUpdate("INSERT INTO Technician VALUES ('mehmett@novacorp.me');");


            //Filling Manager Table
            statement.executeUpdate("INSERT INTO Manager VALUES ('burcuc@novacorp.me',2005);");
            statement.executeUpdate("INSERT INTO Manager VALUES ('alexs@novacorp.me',2007);");
            statement.executeUpdate("INSERT INTO Manager VALUES ('canerc@yahoo.com',2008);");
            statement.executeUpdate("INSERT INTO Manager VALUES ('rustur@yahoo.com',2014);");
            statement.executeUpdate("INSERT INTO Manager VALUES ('lionelm@yahoo.com',2012);");


            //Filling Supplier Table
            statement.executeUpdate("INSERT INTO Supplier VALUES ('Cakmaklar BMC','03122787001','Oto Sanayi Sitesi 2467.Sokak No:31 Sasmaz Ankara','Kaan Yorgan');");
            statement.executeUpdate("INSERT INTO Supplier VALUES ('Evrenler Oto','03122782268','Oto Sanayi Sitesi 8.Sokak No:86 Sasmaz Ankara','Arda Usman');");
            statement.executeUpdate("INSERT INTO Supplier VALUES ('Oto Fatih','03122787880','Oto Sanayi Sitesi 1.Cadde 1.Sokak No:2 Sasmaz Ankara','Fatih Caner');");


            //Filling SparePart Table
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Air Filter','Opel',100,50);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Air Filter','BMW',300,150);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Air Filter','VW',100,60);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Air Filter','Mercedes',200,160);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Oil Filter','Opel',300,200);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Oil Filter','BMW',500,250);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Oil Filter','VW',500,250);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Oil Filter','Mercedes',600,300);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Spark Plug','Opel',200,250);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Spark Plug','BMW',400,350);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Spark Plug','VW',200,260);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Spark Plug','Mercedes',100,300);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Battery','Opel',200,1250);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Battery','BMW',400,1350);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Battery','VW',200,1260);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Battery','Mercedes',100,1300);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Wiper','Opel',200,80);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Wiper','BMW',400,120);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Wiper','VW',200,70);");
            statement.executeUpdate("INSERT INTO SparePart VALUES ('Wiper','Mercedes',100,130);");


            //Filling Supply Table
            statement.executeUpdate("INSERT INTO Supply VALUES ('Wiper','Opel','Cakmaklar BMC');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Wiper','BMW','Cakmaklar BMC');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Battery','Opel','Cakmaklar BMC');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Battery','BMW','Cakmaklar BMC');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Wiper','Opel','Evrenler Oto');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Wiper','BMW','Evrenler Oto');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Air Filter','Opel','Evrenler Oto');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Oil Filter','BMW','Oto Fatih');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Oil Filter','Opel','Oto Fatih');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Wiper','BMW','Oto Fatih');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Battery','Opel','Oto Fatih');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Battery','BMW','Oto Fatih');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Spark Plug','BMW','Oto Fatih');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Spark Plug','Opel','Cakmaklar BMC');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Spark Plug','Mercedes','Oto Fatih');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Spark Plug','Mercedes','Cakmaklar BMC');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Spark Plug','VW','Oto Fatih');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Air Filter','VW','Evrenler Oto');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Oil Filter','VW','Evrenler Oto');");
            statement.executeUpdate("INSERT INTO Supply VALUES ('Oil Filter','VW','Oto Fatih');");


            //Filling Operation Table
            statement.executeUpdate("INSERT INTO Operation VALUES ('Maintenance','Washing',50, NULL, NULL);");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Maintenance','Lights',200, NULL, NULL);");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Maintenance','Electronic',1500, 'Battery', 'Opel');");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Maintenance','Windshield',1200, 'Wiper', 'Opel');");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Maintenance','Engine',4000, NULL, NULL);");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Maintenance','Tires',300, NULL, NULL);");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Repair','Lights',500, NULL, NULL);");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Repair','Electronic',3500, 'Battery', 'BMW');");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Repair','Windshield',2200, 'Wiper', 'BMW');");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Repair','Engine',6000, NULL, NULL);");
            statement.executeUpdate("INSERT INTO Operation VALUES ('Repair','Tires',1300, NULL, NULL);");


            //Filling Transaction Table (id - amount - date)
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (150,'2015-02-11');");
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (200,'2015-04-21');");
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (350,'2015-11-14');");
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (150,'2015-04-02');");
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (400,'2015-05-26');");
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (150,'2016-04-22');");
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (400,'2016-03-16');");
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (150,'2016-01-22');");
            statement.executeUpdate("INSERT INTO Transaction (amount, date) VALUES (400,'2015-12-28');");


            //Filling TechnicianOperation Table
            statement.executeUpdate("INSERT INTO TechnicianOperation VALUES ('Repair','Lights','onatkutd@novacorp.me');");
            statement.executeUpdate("INSERT INTO TechnicianOperation VALUES ('Repair','Engine','mehmett@novacorp.me');");
            statement.executeUpdate("INSERT INTO TechnicianOperation VALUES ('Maintenance','Lights','yasemind@novacorp.me');");
            statement.executeUpdate("INSERT INTO TechnicianOperation VALUES ('Maintenance','Washing','yasemind@novacorp.me');");
            statement.executeUpdate("INSERT INTO TechnicianOperation VALUES ('Repair','Windshield','onatkutd@novacorp.me');");
            statement.executeUpdate("INSERT INTO TechnicianOperation VALUES ('Repair','Tires','onatkutd@novacorp.me');");
            statement.executeUpdate("INSERT INTO TechnicianOperation VALUES ('Maintenance','Windshield','yasemind@novacorp.me');");
            statement.executeUpdate("INSERT INTO TechnicianOperation VALUES ('Maintenance','Engine','yasemind@novacorp.me');");


            //Filling SparePartOrder Table (trans-id - sales_mgr_email - part_type - part_model - supplier name - count)
            statement.executeUpdate("INSERT INTO SparePartOrder VALUES (1,'besteekmekci@yahoo.com','Oil Filter','Opel','Oto Fatih',10);");
            statement.executeUpdate("INSERT INTO SparePartOrder VALUES (2,'besteekmekci@yahoo.com','Battery','BMW','Cakmaklar BMC',5);");
            statement.executeUpdate("INSERT INTO SparePartOrder VALUES (3,'besteekmekci@yahoo.com','Spark Plug','Mercedes','Oto Fatih',20);");
            statement.executeUpdate("INSERT INTO SparePartOrder VALUES (4,'besteekmekci@yahoo.com','Wiper','BMW','Evrenler Oto',12);");


            //Filling CustomerOperation (transaction_id, dept_name, op_name, tech_email, clerk_email, customer_email, auto?_plate)
            statement.executeUpdate("INSERT INTO CustomerOperation VALUES (5,'Repair','Windshield','onatkutd@novacorp.me','anik@novacorp.me','berkcang@gmail.com','06 GG 2016');");
            statement.executeUpdate("INSERT INTO CustomerOperation VALUES (6,'Repair','Tires','onatkutd@novacorp.me','anik@novacorp.me','sahink@novacorp.me','06 GNR 95');");
            statement.executeUpdate("INSERT INTO CustomerOperation VALUES (7,'Maintenance','Lights','yasemind@novacorp.me','anik@novacorp.me','arifu@bilkent.com','06 CS 2012');");
            statement.executeUpdate("INSERT INTO CustomerOperation VALUES (8,'Maintenance','Washing','yasemind@novacorp.me','anik@novacorp.me','ozguru@bilkent.com','06 DB 2016');");
            statement.executeUpdate("INSERT INTO CustomerOperation VALUES (9,'Repair','Engine','mehmett@novacorp.me','anik@novacorp.me','asild@novacorp.me','06 AVD 07');");

            // TODO add trigger

            // Create the secondary index on first name and last name of User
            statement.executeUpdate("CREATE INDEX user_first_name_index ON User(first_name(20));");
            statement.executeUpdate("CREATE INDEX user_last_name_index ON User(last_name(20));");

            // Create the views
            statement.executeUpdate(
                    "CREATE VIEW list_of_customers AS (" +
                        "SELECT u.email, u.first_name, u.last_name " +
                        "FROM (User u NATURAL JOIN Customer c)" +
                    ");");
            statement.executeUpdate(
                    "CREATE VIEW list_of_employees AS (" +
                        "SELECT u.email, u.first_name, u.last_name, e.dept_name " +
                        "FROM (User u NATURAL JOIN Employee e)" +
                    ")");

            // Create the triggers
            statement.executeUpdate(
                    "CREATE TRIGGER update_spare_parts " +
                    "AFTER INSERT ON SparePartOrder " +
                    "FOR EACH ROW " +
                    "BEGIN " +
                        "IF NEW.count > 0 THEN " +
                            "UPDATE SparePart " +
                            "SET stock_quantity = stock_quantity + NEW.count " +
                            "WHERE type = NEW.part_type " +
                            "AND model = NEW.part_model; " +
                        "END IF; " +
                    "END; ");
            statement.executeUpdate(
                    "CREATE TRIGGER remove_spare_parts " +
                    "AFTER INSERT ON CustomerOperation " +
                    "FOR EACH ROW " +
                    "BEGIN " +
                        "IF (" +
                            "SELECT sparepart_type " +
                            "FROM Operation O " +
                            "WHERE O.dept_name = NEW.dept_name " +
                            "AND O.op_name = NEW.op_name " +
                        ") IS NOT NULL " +
                        "THEN " +
                            "UPDATE SparePart " +
                            "SET stock_quantity = stock_quantity + (-1) " +
                            "WHERE type = ( " +
                                "SELECT sparepart_type " +
                                "FROM Operation " +
                                "WHERE O.dept_name = NEW.dept_name " +
                                "AND " +
                                "O.op_name = NEW.op_name " +
                            ") " +
                            "AND " +
                            "model = ( " +
                                "SELECT sparepart_model " +
                                "FROM Operation " +
                                "WHERE  O.dept_name = NEW.dept_name " +
                                "AND " +
                                "O.op_name = NEW.op_name" +
                            "); " +
                        "END IF; " +
                    "END;");

        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }
}