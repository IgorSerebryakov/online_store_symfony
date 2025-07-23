<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416102116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add product table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE product (
                id SERIAL NOT NULL, 
                name VARCHAR(255) NOT NULL, 
                slug VARCHAR(255) NOT NULL, 
                description TEXT DEFAULT NULL, 
                price NUMERIC(10, 2) NOT NULL, 
                old_price NUMERIC(10, 2) DEFAULT NULL, 
                sku INT NOT NULL, quantity INT DEFAULT 0 NOT NULL, 
                is_active BOOLEAN DEFAULT false NOT NULL, 
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_D34A04AD989D9B62 ON product (slug)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_D34A04ADF9038C4 ON product (sku)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.name IS 'Название товара'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.slug IS 'Человеко-понятный URL-идентификатор товара'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.description IS 'Полное описание товара'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.price IS 'Текущая цена товара'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.old_price IS 'Старая цена (для отображения скидки)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.sku IS 'Артикул/уникальный код товара (Stock Keeping Unit)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.quantity IS 'Количество товара на складе'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.is_active IS 'Флаг активности товара (отображается ли на сайте)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.created_at IS 'Дата и время создания записи(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN product.updated_at IS 'Дата и время последнего обновления(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
    }
}
