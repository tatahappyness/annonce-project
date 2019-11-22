<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191121065413 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, article_categ_id_id INT DEFAULT NULL, article_sous_categ_id_id INT DEFAULT NULL, article_title VARCHAR(255) DEFAULT NULL, article_date_crea DATETIME DEFAULT NULL, img VARCHAR(200) DEFAULT NULL, icon VARCHAR(200) DEFAULT NULL, is_popular TINYINT(1) DEFAULT NULL, INDEX IDX_23A0E6639FCD9F9 (article_categ_id_id), INDEX IDX_23A0E66F412BBDE (article_sous_categ_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mode_prix (id INT AUTO_INCREMENT NOT NULL, prix_article_id_id INT DEFAULT NULL, prix_sous_category_id_id INT DEFAULT NULL, prix_title VARCHAR(255) DEFAULT NULL, prix_description TINYTEXT DEFAULT NULL, prix_image VARCHAR(255) DEFAULT NULL, prix_globale VARCHAR(255) DEFAULT NULL, prix_moyen VARCHAR(255) DEFAULT NULL, prix_haut_gamme VARCHAR(255) DEFAULT NULL, prix_date_crea DATETIME DEFAULT NULL, INDEX IDX_9C65B0D450C456C (prix_article_id_id), INDEX IDX_9C65B0D970AEB7F (prix_sous_category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, customer_id_id INT DEFAULT NULL, service_id_id INT DEFAULT NULL, date_payement DATETIME DEFAULT NULL, date_expire DATETIME DEFAULT NULL, INDEX IDX_351268BBB171EB6C (customer_id_id), INDEX IDX_351268BBD63673B0 (service_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalogue_site (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, categ_title VARCHAR(255) DEFAULT NULL, categ_date_crea DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chantier_of_month (id INT AUTO_INCREMENT NOT NULL, category_id_id INT DEFAULT NULL, article_id_id INT DEFAULT NULL, description VARCHAR(250) DEFAULT NULL, image_befor VARCHAR(250) DEFAULT NULL, image_after VARCHAR(250) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_FAC29C5F9777D11E (category_id_id), INDEX IDX_FAC29C5F8F3EC46 (article_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, ville_id INT DEFAULT NULL, ville_departement VARCHAR(4) DEFAULT NULL, ville_slug VARCHAR(255) DEFAULT NULL, ville_nom VARCHAR(50) DEFAULT NULL, ville_nom_simple VARCHAR(50) DEFAULT NULL, ville_nom_reel VARCHAR(50) DEFAULT NULL, ville_nom_soundex VARCHAR(25) DEFAULT NULL, ville_nom_metaphone VARCHAR(25) DEFAULT NULL, ville_code_postal VARCHAR(255) DEFAULT NULL, ville_commune VARCHAR(5) DEFAULT NULL, ville_code_commune VARCHAR(8) DEFAULT NULL, ville_arrondissement INT DEFAULT NULL, ville_canton VARCHAR(8) DEFAULT NULL, ville_amdi INT DEFAULT NULL, ville_population_2010 INT DEFAULT NULL, ville_population_1999 INT DEFAULT NULL, ville_population_2012 INT DEFAULT NULL, ville_densite_2010 INT DEFAULT NULL, ville_surface DOUBLE PRECISION DEFAULT NULL, ville_longitude_deg DOUBLE PRECISION DEFAULT NULL, ville_latitude_deg DOUBLE PRECISION DEFAULT NULL, ville_longitude_grd VARCHAR(15) DEFAULT NULL, ville_latitude_grd VARCHAR(15) DEFAULT NULL, ville_longitude_dms VARCHAR(15) DEFAULT NULL, ville_latitude_dms VARCHAR(15) DEFAULT NULL, ville_zmin INT DEFAULT NULL, ville_zmax INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_pro TINYINT(1) DEFAULT NULL, is_particular TINYINT(1) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, is_publish TINYINT(1) DEFAULT NULL, INDEX IDX_5F9E962A9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configsite (id INT AUTO_INCREMENT NOT NULL, nomsite VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, numphone VARCHAR(25) NOT NULL, image VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conseil (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, customer_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_81398E099D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis (id INT AUTO_INCREMENT NOT NULL, dev_user_id_id INT DEFAULT NULL, dev_user_id_dest_id INT DEFAULT NULL, nature_project_id INT DEFAULT NULL, fonction_id_id INT DEFAULT NULL, type_project_id INT DEFAULT NULL, city_id INT DEFAULT NULL, category_id_id INT DEFAULT NULL, detail_project LONGTEXT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, user_name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, email VARCHAR(150) DEFAULT NULL, zip_code VARCHAR(8) DEFAULT NULL, is_accepted_condition TINYINT(1) NOT NULL, civility VARCHAR(4) DEFAULT NULL, is_ask_demande TINYINT(1) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, appartement_type VARCHAR(250) DEFAULT NULL, INDEX IDX_8B27C52B92B1037 (dev_user_id_id), INDEX IDX_8B27C52B944D5CF (dev_user_id_dest_id), INDEX IDX_8B27C52BFA13AC0B (nature_project_id), INDEX IDX_8B27C52B1DECB9C6 (fonction_id_id), INDEX IDX_8B27C52BB6EC9B9 (type_project_id), INDEX IDX_8B27C52B8BAC62AF (city_id), INDEX IDX_8B27C52B9777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_accept (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, devis_id_id INT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_8F352AF89D86650F (user_id_id), INDEX IDX_8F352AF869678373 (devis_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_finish (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, devis_valid_id INT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_1CDC2CD49D86650F (user_id_id), INDEX IDX_1CDC2CD486C35500 (devis_valid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_valid (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, devis_accept_id_id INT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_9A2428DB9D86650F (user_id_id), INDEX IDX_9A2428DBAA508A34 (devis_accept_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_viewed (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, devis_id_id INT DEFAULT NULL, isclicked TINYINT(1) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_CB9DDEC89D86650F (user_id_id), INDEX IDX_CB9DDEC869678373 (devis_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documment (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, title VARCHAR(200) DEFAULT NULL, name VARCHAR(200) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_4518DAFE9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emoji (id INT AUTO_INCREMENT NOT NULL, date_crea DATETIME DEFAULT NULL, code LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluations (id INT AUTO_INCREMENT NOT NULL, user_pro_id_id INT DEFAULT NULL, user_part_id_id INT DEFAULT NULL, have_start VARCHAR(200) DEFAULT NULL, motif LONGTEXT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_3B72691DC17F2316 (user_pro_id_id), INDEX IDX_3B72691D4B500F58 (user_part_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, fonction_name VARCHAR(250) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guide_price (id INT AUTO_INCREMENT NOT NULL, sous_category_id_id INT DEFAULT NULL, article_id_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, date_crea DATETIME DEFAULT NULL, subject_link VARCHAR(250) DEFAULT NULL, image VARCHAR(250) DEFAULT NULL, INDEX IDX_8ED5E991EA4D28AA (sous_category_id_id), INDEX IDX_8ED5E9918F3EC46 (article_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, article_title_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, name VARCHAR(200) DEFAULT NULL, INDEX IDX_E01FBE6A5F7773D6 (article_title_id), INDEX IDX_E01FBE6A9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE labels (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, title VARCHAR(200) DEFAULT NULL, name VARCHAR(200) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_B5D102119D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newletter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, category_id_id INT DEFAULT NULL, offer_price DOUBLE PRECISION DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_29D6873E9777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_email (id INT AUTO_INCREMENT NOT NULL, typekey VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, post_user_id_id INT NOT NULL, type_id_id INT DEFAULT NULL, category_id_id INT DEFAULT NULL, city_id INT DEFAULT NULL, article_id_id INT DEFAULT NULL, post_location VARCHAR(200) DEFAULT NULL, post_zipcode VARCHAR(200) DEFAULT NULL, post_region VARCHAR(200) DEFAULT NULL, post_latitude VARCHAR(255) DEFAULT NULL, post_longitude VARCHAR(255) DEFAULT NULL, post_ads_travaux_description LONGTEXT DEFAULT NULL, post_ads_date_crea DATETIME DEFAULT NULL, post_ads_type_client VARCHAR(200) DEFAULT NULL, post_ads_type_habitation VARCHAR(200) DEFAULT NULL, post_ads_start_date VARCHAR(255) DEFAULT NULL, post_ads_travaux_surface VARCHAR(200) DEFAULT NULL, post_ads_etat_terrain VARCHAR(200) DEFAULT NULL, email VARCHAR(200) DEFAULT NULL, phone VARCHAR(16) DEFAULT NULL, INDEX IDX_5A8A6C8DBEFE6CCE (post_user_id_id), INDEX IDX_5A8A6C8D714819A0 (type_id_id), INDEX IDX_5A8A6C8D9777D11E (category_id_id), INDEX IDX_5A8A6C8D8BAC62AF (city_id), INDEX IDX_5A8A6C8D8F3EC46 (article_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_post_ads (id INT AUTO_INCREMENT NOT NULL, user_part_id_id INT NOT NULL, user_pro_id_id INT DEFAULT NULL, post_ads_id_id INT DEFAULT NULL, message LONGTEXT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_7802F4244B500F58 (user_part_id_id), INDEX IDX_7802F424C17F2316 (user_pro_id_id), INDEX IDX_7802F424C1E04821 (post_ads_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, category_id_id INT DEFAULT NULL, is_actived TINYINT(1) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_7332E1699D86650F (user_id_id), INDEX IDX_7332E1699777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE siteinternet (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_category (id INT AUTO_INCREMENT NOT NULL, cat_sous_category_id INT DEFAULT NULL, sous_categ_title VARCHAR(255) DEFAULT NULL, sous_categ_date_crea DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, sous_categ_intro LONGTEXT DEFAULT NULL, sous_categ_link_question VARCHAR(255) DEFAULT NULL, INDEX IDX_E022D94C38715A8 (cat_sous_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, customer_id_id INT DEFAULT NULL, transaction_id VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, date_crea DATETIME DEFAULT NULL, INDEX IDX_723705D1B171EB6C (customer_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date_crea DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_category_activity_id INT DEFAULT NULL, user_city_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, mobile VARCHAR(15) DEFAULT NULL, business_category VARCHAR(255) DEFAULT NULL, business_sub_category VARCHAR(255) DEFAULT NULL, company_title VARCHAR(255) DEFAULT NULL, is_accept_condition_term TINYINT(1) DEFAULT NULL, is_business TINYINT(1) DEFAULT NULL, is_professional TINYINT(1) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, profil_image VARCHAR(255) DEFAULT NULL, member_type VARCHAR(100) DEFAULT NULL, is_activity TINYINT(1) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, is_particular TINYINT(1) DEFAULT NULL, siret_number VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(15) DEFAULT NULL, lat LONGTEXT DEFAULT NULL, log LONGTEXT DEFAULT NULL, free_date_expire DATETIME DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, date_crea DATETIME DEFAULT NULL, company_carater VARCHAR(255) DEFAULT NULL, companydescription LONGTEXT DEFAULT NULL, company_date_crea VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649887AF182 (user_category_activity_id), INDEX IDX_8D93D649D3A17CA5 (user_city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos (id INT AUTO_INCREMENT NOT NULL, article_title_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_29AA64325F7773D6 (article_title_id), INDEX IDX_29AA64329D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6639FCD9F9 FOREIGN KEY (article_categ_id_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F412BBDE FOREIGN KEY (article_sous_categ_id_id) REFERENCES sous_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE mode_prix ADD CONSTRAINT FK_9C65B0D450C456C FOREIGN KEY (prix_article_id_id) REFERENCES article (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE mode_prix ADD CONSTRAINT FK_9C65B0D970AEB7F FOREIGN KEY (prix_sous_category_id_id) REFERENCES sous_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBB171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBD63673B0 FOREIGN KEY (service_id_id) REFERENCES services (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chantier_of_month ADD CONSTRAINT FK_FAC29C5F9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE chantier_of_month ADD CONSTRAINT FK_FAC29C5F8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E099D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B92B1037 FOREIGN KEY (dev_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B944D5CF FOREIGN KEY (dev_user_id_dest_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BFA13AC0B FOREIGN KEY (nature_project_id) REFERENCES article (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B1DECB9C6 FOREIGN KEY (fonction_id_id) REFERENCES fonction (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BB6EC9B9 FOREIGN KEY (type_project_id) REFERENCES type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE devis_accept ADD CONSTRAINT FK_8F352AF89D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_accept ADD CONSTRAINT FK_8F352AF869678373 FOREIGN KEY (devis_id_id) REFERENCES devis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_finish ADD CONSTRAINT FK_1CDC2CD49D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_finish ADD CONSTRAINT FK_1CDC2CD486C35500 FOREIGN KEY (devis_valid_id) REFERENCES devis_valid (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_valid ADD CONSTRAINT FK_9A2428DB9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_valid ADD CONSTRAINT FK_9A2428DBAA508A34 FOREIGN KEY (devis_accept_id_id) REFERENCES devis_accept (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_viewed ADD CONSTRAINT FK_CB9DDEC89D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_viewed ADD CONSTRAINT FK_CB9DDEC869678373 FOREIGN KEY (devis_id_id) REFERENCES devis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE documment ADD CONSTRAINT FK_4518DAFE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluations ADD CONSTRAINT FK_3B72691DC17F2316 FOREIGN KEY (user_pro_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluations ADD CONSTRAINT FK_3B72691D4B500F58 FOREIGN KEY (user_part_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE guide_price ADD CONSTRAINT FK_8ED5E991EA4D28AA FOREIGN KEY (sous_category_id_id) REFERENCES sous_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE guide_price ADD CONSTRAINT FK_8ED5E9918F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A5F7773D6 FOREIGN KEY (article_title_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE labels ADD CONSTRAINT FK_B5D102119D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DBEFE6CCE FOREIGN KEY (post_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D714819A0 FOREIGN KEY (type_id_id) REFERENCES type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D9777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE reponse_post_ads ADD CONSTRAINT FK_7802F4244B500F58 FOREIGN KEY (user_part_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_post_ads ADD CONSTRAINT FK_7802F424C17F2316 FOREIGN KEY (user_pro_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_post_ads ADD CONSTRAINT FK_7802F424C1E04821 FOREIGN KEY (post_ads_id_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E1699D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E1699777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sous_category ADD CONSTRAINT FK_E022D94C38715A8 FOREIGN KEY (cat_sous_category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B171EB6C FOREIGN KEY (customer_id_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649887AF182 FOREIGN KEY (user_category_activity_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D3A17CA5 FOREIGN KEY (user_city_id) REFERENCES cities (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA64325F7773D6 FOREIGN KEY (article_title_id) REFERENCES article (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA64329D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE abonnenent');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mode_prix DROP FOREIGN KEY FK_9C65B0D450C456C');
        $this->addSql('ALTER TABLE chantier_of_month DROP FOREIGN KEY FK_FAC29C5F8F3EC46');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BFA13AC0B');
        $this->addSql('ALTER TABLE guide_price DROP FOREIGN KEY FK_8ED5E9918F3EC46');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A5F7773D6');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8F3EC46');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA64325F7773D6');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6639FCD9F9');
        $this->addSql('ALTER TABLE chantier_of_month DROP FOREIGN KEY FK_FAC29C5F9777D11E');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B9777D11E');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E9777D11E');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D9777D11E');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1699777D11E');
        $this->addSql('ALTER TABLE sous_category DROP FOREIGN KEY FK_E022D94C38715A8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649887AF182');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B8BAC62AF');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8BAC62AF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D3A17CA5');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBB171EB6C');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B171EB6C');
        $this->addSql('ALTER TABLE devis_accept DROP FOREIGN KEY FK_8F352AF869678373');
        $this->addSql('ALTER TABLE devis_viewed DROP FOREIGN KEY FK_CB9DDEC869678373');
        $this->addSql('ALTER TABLE devis_valid DROP FOREIGN KEY FK_9A2428DBAA508A34');
        $this->addSql('ALTER TABLE devis_finish DROP FOREIGN KEY FK_1CDC2CD486C35500');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B1DECB9C6');
        $this->addSql('ALTER TABLE reponse_post_ads DROP FOREIGN KEY FK_7802F424C1E04821');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBD63673B0');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F412BBDE');
        $this->addSql('ALTER TABLE mode_prix DROP FOREIGN KEY FK_9C65B0D970AEB7F');
        $this->addSql('ALTER TABLE guide_price DROP FOREIGN KEY FK_8ED5E991EA4D28AA');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BB6EC9B9');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D714819A0');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A9D86650F');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E099D86650F');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B92B1037');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B944D5CF');
        $this->addSql('ALTER TABLE devis_accept DROP FOREIGN KEY FK_8F352AF89D86650F');
        $this->addSql('ALTER TABLE devis_finish DROP FOREIGN KEY FK_1CDC2CD49D86650F');
        $this->addSql('ALTER TABLE devis_valid DROP FOREIGN KEY FK_9A2428DB9D86650F');
        $this->addSql('ALTER TABLE devis_viewed DROP FOREIGN KEY FK_CB9DDEC89D86650F');
        $this->addSql('ALTER TABLE documment DROP FOREIGN KEY FK_4518DAFE9D86650F');
        $this->addSql('ALTER TABLE evaluations DROP FOREIGN KEY FK_3B72691DC17F2316');
        $this->addSql('ALTER TABLE evaluations DROP FOREIGN KEY FK_3B72691D4B500F58');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A9D86650F');
        $this->addSql('ALTER TABLE labels DROP FOREIGN KEY FK_B5D102119D86650F');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DBEFE6CCE');
        $this->addSql('ALTER TABLE reponse_post_ads DROP FOREIGN KEY FK_7802F4244B500F58');
        $this->addSql('ALTER TABLE reponse_post_ads DROP FOREIGN KEY FK_7802F424C17F2316');
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1699D86650F');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA64329D86650F');
        $this->addSql('CREATE TABLE abonnenent (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE mode_prix');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE catalogue_site');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE chantier_of_month');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE configsite');
        $this->addSql('DROP TABLE conseil');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE devis_accept');
        $this->addSql('DROP TABLE devis_finish');
        $this->addSql('DROP TABLE devis_valid');
        $this->addSql('DROP TABLE devis_viewed');
        $this->addSql('DROP TABLE documment');
        $this->addSql('DROP TABLE emoji');
        $this->addSql('DROP TABLE evaluations');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE guide_price');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE labels');
        $this->addSql('DROP TABLE newletter');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE option_email');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE reponse_post_ads');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE siteinternet');
        $this->addSql('DROP TABLE sous_category');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE videos');
    }
}
