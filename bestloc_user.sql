USE bestloc;

CREATE USER 'bestloc'@'%' IDENTIFIED BY 'bCslib@01!';

-- Il se peut que les droits ne s'accordent pas correctement
GRANT SELECT, INSERT, UPDATE, DELETE ON bestloc.* TO 'bestloc'@'%';

SHOW GRANTS FOR 'bestloc'@'%';

FLUSH PRIVILEGES;