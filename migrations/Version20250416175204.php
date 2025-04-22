<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416175204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concours (id INT AUTO_INCREMENT NOT NULL, token BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(200) NOT NULL, annee INT NOT NULL, date_debut_inscription DATETIME NOT NULL, date_fin_inscription DATETIME NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, UNIQUE INDEX UNIQ_4FAE51965F37A13B (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gouvernorat (id INT AUTO_INCREMENT NOT NULL, libelle_gouv VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, concours_id INT NOT NULL, token BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', libelle VARCHAR(60) NOT NULL, nbre_postes INT NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, UNIQUE INDEX UNIQ_595AAE345F37A13B (token), INDEX IDX_595AAE34D11E3C7 (concours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, grade VARCHAR(10) NOT NULL, cin VARCHAR(8) NOT NULL, id_dossier INT NOT NULL, date_creation DATETIME NOT NULL, phase VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id_dossier INT AUTO_INCREMENT NOT NULL, code_gouv_id INT NOT NULL, specialite_id INT NOT NULL, token BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', date_inscription DATETIME NOT NULL, cin VARCHAR(8) NOT NULL, date_cin DATE NOT NULL, prenom VARCHAR(30) NOT NULL, nom VARCHAR(30) NOT NULL, prenom_pere VARCHAR(30) NOT NULL, prenom_mere VARCHAR(30) NOT NULL, nom_jeunefille VARCHAR(30) NOT NULL, date_naissance DATE NOT NULL, ville_naissance VARCHAR(2) NOT NULL, sexe VARCHAR(4) NOT NULL, etat_civil VARCHAR(5) NOT NULL, nom_prenom_conjoint VARCHAR(60) DEFAULT NULL, emploi_conjoint VARCHAR(30) DEFAULT NULL, nb_enfants VARCHAR(2) DEFAULT NULL, adresse VARCHAR(300) NOT NULL, region_adresse VARCHAR(30) NOT NULL, code_gouv_adresse VARCHAR(2) NOT NULL, code_postal VARCHAR(4) NOT NULL, telephone_fixe VARCHAR(8) DEFAULT NULL, telephone_portable VARCHAR(8) NOT NULL, mail VARCHAR(30) NOT NULL, niveau VARCHAR(10) NOT NULL, niveau_affiche VARCHAR(400) NOT NULL, nom_diplome VARCHAR(100) NOT NULL, specialite_diplome VARCHAR(200) DEFAULT NULL, type_etablissement VARCHAR(7) NOT NULL, annee_diplome VARCHAR(4) NOT NULL, annee_equivalence VARCHAR(4) DEFAULT NULL, nom_etablissement VARCHAR(200) NOT NULL, moyenne1 VARCHAR(6) NOT NULL, moyenne2 VARCHAR(6) NOT NULL, moyenne3 VARCHAR(6) DEFAULT NULL, moyenne4 VARCHAR(6) DEFAULT NULL, moyenne5 VARCHAR(6) DEFAULT NULL, moyenne_generale VARCHAR(6) NOT NULL, score_tanfil VARCHAR(6) NOT NULL, total_score VARCHAR(6) NOT NULL, diplome_tanfil VARCHAR(9) NOT NULL, confirm_guide TINYINT(1) NOT NULL, confirm_decision TINYINT(1) NOT NULL, confirm_programme TINYINT(1) NOT NULL, confirm_fiche TINYINT(1) NOT NULL, grade INT NOT NULL, UNIQUE INDEX UNIQ_5E90F6D65F37A13B (token), INDEX IDX_5E90F6D6F41ED8DB (code_gouv_id), INDEX IDX_5E90F6D62195E0F0 (specialite_id), UNIQUE INDEX my_unique_index (grade, cin), PRIMARY KEY(id_dossier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_convocation (id INT AUTO_INCREMENT NOT NULL, rang_grade INT NOT NULL, id_dossier INT NOT NULL, cin VARCHAR(8) NOT NULL, date_naissance VARCHAR(10) NOT NULL, nom_prenom VARCHAR(31) NOT NULL, telephone VARCHAR(8) DEFAULT NULL, score_total VARCHAR(6) NOT NULL, rang INT NOT NULL, gouv_concours VARCHAR(30) NOT NULL, specialite VARCHAR(30) NOT NULL, id_specialite VARCHAR(30) NOT NULL, id_grade VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_disabled (id INT AUTO_INCREMENT NOT NULL, code_gouv_id INT NOT NULL, specialite_id INT NOT NULL, user_id INT NOT NULL, id_dossier INT NOT NULL, token BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', date_inscription DATETIME NOT NULL, cin VARCHAR(8) NOT NULL, date_cin DATE NOT NULL, prenom VARCHAR(30) NOT NULL, nom VARCHAR(30) NOT NULL, prenom_pere VARCHAR(30) NOT NULL, prenom_mere VARCHAR(30) NOT NULL, nom_jeunefille VARCHAR(30) NOT NULL, date_naissance DATE NOT NULL, ville_naissance VARCHAR(2) NOT NULL, sexe VARCHAR(4) NOT NULL, etat_civil VARCHAR(5) NOT NULL, nom_prenom_conjoint VARCHAR(60) DEFAULT NULL, emploi_conjoint VARCHAR(30) DEFAULT NULL, nb_enfants VARCHAR(2) DEFAULT NULL, adresse VARCHAR(300) NOT NULL, region_adresse VARCHAR(30) NOT NULL, code_gouv_adresse VARCHAR(2) NOT NULL, code_postal VARCHAR(4) NOT NULL, telephone_fixe VARCHAR(8) DEFAULT NULL, telephone_portable VARCHAR(8) NOT NULL, mail VARCHAR(30) NOT NULL, niveau VARCHAR(10) NOT NULL, niveau_affiche VARCHAR(400) NOT NULL, nom_diplome VARCHAR(100) NOT NULL, specialite_diplome VARCHAR(200) DEFAULT NULL, type_etablissement VARCHAR(7) NOT NULL, annee_diplome VARCHAR(4) NOT NULL, annee_equivalence VARCHAR(4) DEFAULT NULL, nom_etablissement VARCHAR(200) NOT NULL, moyenne1 VARCHAR(6) NOT NULL, moyenne2 VARCHAR(6) NOT NULL, moyenne3 VARCHAR(6) DEFAULT NULL, moyenne4 VARCHAR(6) DEFAULT NULL, moyenne5 VARCHAR(6) DEFAULT NULL, moyenne_generale VARCHAR(6) NOT NULL, score_tanfil VARCHAR(6) NOT NULL, total_score VARCHAR(6) NOT NULL, diplome_tanfil VARCHAR(9) NOT NULL, confirm_guide TINYINT(1) NOT NULL, confirm_decision TINYINT(1) NOT NULL, confirm_programme TINYINT(1) NOT NULL, confirm_fiche TINYINT(1) NOT NULL, grade INT NOT NULL, motif_desactivation VARCHAR(150) NOT NULL, is_disabled TINYINT(1) NOT NULL, date_desactivation DATETIME NOT NULL, UNIQUE INDEX UNIQ_2D6B11465F37A13B (token), INDEX IDX_2D6B1146F41ED8DB (code_gouv_id), INDEX IDX_2D6B11462195E0F0 (specialite_id), INDEX IDX_2D6B1146A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phase (id INT AUTO_INCREMENT NOT NULL, concours_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, is_enabled TINYINT(1) NOT NULL, grades JSON DEFAULT NULL, INDEX IDX_B1BDD6CBD11E3C7 (concours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, grade_id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, cin VARCHAR(8) NOT NULL, date_cin DATE NOT NULL, date_naissance DATE NOT NULL, mail VARCHAR(30) NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, objet VARCHAR(300) NOT NULL, INDEX IDX_CE606404FE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score_region (id INT AUTO_INCREMENT NOT NULL, dernier_score_total VARCHAR(6) NOT NULL, gouv_concours VARCHAR(30) NOT NULL, id_gouv INT NOT NULL, specialite VARCHAR(30) NOT NULL, id_specialite VARCHAR(30) NOT NULL, id_grade VARCHAR(2) NOT NULL, date_naissance_dernier_candidat_admis VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, grade_id INT NOT NULL, libelle VARCHAR(60) NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME NOT NULL, INDEX IDX_E7D6FCC1FE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gouvernorats_specialites (specialite_id INT NOT NULL, gouvernorat_id INT NOT NULL, INDEX IDX_83CAC6DC2195E0F0 (specialite_id), INDEX IDX_83CAC6DC75B74E2D (gouvernorat_id), PRIMARY KEY(specialite_id, gouvernorat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(60) NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34D11E3C7 FOREIGN KEY (concours_id) REFERENCES concours (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6F41ED8DB FOREIGN KEY (code_gouv_id) REFERENCES gouvernorat (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D62195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE inscription_disabled ADD CONSTRAINT FK_2D6B1146F41ED8DB FOREIGN KEY (code_gouv_id) REFERENCES gouvernorat (id)');
        $this->addSql('ALTER TABLE inscription_disabled ADD CONSTRAINT FK_2D6B11462195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE inscription_disabled ADD CONSTRAINT FK_2D6B1146A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT FK_B1BDD6CBD11E3C7 FOREIGN KEY (concours_id) REFERENCES concours (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE specialite ADD CONSTRAINT FK_E7D6FCC1FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE gouvernorats_specialites ADD CONSTRAINT FK_83CAC6DC2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gouvernorats_specialites ADD CONSTRAINT FK_83CAC6DC75B74E2D FOREIGN KEY (gouvernorat_id) REFERENCES gouvernorat (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34D11E3C7');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6F41ED8DB');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D62195E0F0');
        $this->addSql('ALTER TABLE inscription_disabled DROP FOREIGN KEY FK_2D6B1146F41ED8DB');
        $this->addSql('ALTER TABLE inscription_disabled DROP FOREIGN KEY FK_2D6B11462195E0F0');
        $this->addSql('ALTER TABLE inscription_disabled DROP FOREIGN KEY FK_2D6B1146A76ED395');
        $this->addSql('ALTER TABLE phase DROP FOREIGN KEY FK_B1BDD6CBD11E3C7');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404FE19A1A8');
        $this->addSql('ALTER TABLE specialite DROP FOREIGN KEY FK_E7D6FCC1FE19A1A8');
        $this->addSql('ALTER TABLE gouvernorats_specialites DROP FOREIGN KEY FK_83CAC6DC2195E0F0');
        $this->addSql('ALTER TABLE gouvernorats_specialites DROP FOREIGN KEY FK_83CAC6DC75B74E2D');
        $this->addSql('DROP TABLE concours');
        $this->addSql('DROP TABLE gouvernorat');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscription_convocation');
        $this->addSql('DROP TABLE inscription_disabled');
        $this->addSql('DROP TABLE phase');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE score_region');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE gouvernorats_specialites');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
