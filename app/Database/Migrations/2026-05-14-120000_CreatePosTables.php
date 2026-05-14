<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePosTables extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('categories')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'default' => new RawSql('CURRENT_TIMESTAMP'),
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('name');
            $this->forge->createTable('categories', true);
        }

        if (!$this->db->tableExists('products')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'sku' => [
                    'type' => 'VARCHAR',
                    'constraint' => 64,
                    'null' => true,
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                ],
                'category_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
                'unit' => [
                    'type' => 'VARCHAR',
                    'constraint' => 30,
                    'null' => true,
                ],
                'cost' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'price' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'stock_qty' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'reorder_level' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'is_active' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 1,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'default' => new RawSql('CURRENT_TIMESTAMP'),
                ],
            ]);
            $this->forge->addField('updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('sku');
            $this->forge->addKey('category_id');
            $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'SET NULL');
            $this->forge->createTable('products', true);
        }

        if (!$this->db->tableExists('sales')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'receipt_no' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ],
                'cashier_user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
                'subtotal' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'discount_total' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'grand_total' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'payment_method' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'default' => 'Cash',
                ],
                'payment_reference' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'amount_tendered' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'change_amount' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'status' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'default' => 'completed',
                ],
                'void_reason' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'voided_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'voided_by' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'default' => new RawSql('CURRENT_TIMESTAMP'),
                ],
            ]);
            $this->forge->addField('sale_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('receipt_no');
            $this->forge->addKey('cashier_user_id');
            $this->forge->addKey('voided_by');
            $this->forge->addForeignKey('cashier_user_id', 'users', 'id', 'CASCADE', 'SET NULL');
            $this->forge->addForeignKey('voided_by', 'users', 'id', 'CASCADE', 'SET NULL');
            $this->forge->createTable('sales', true);
        }

        if (!$this->db->tableExists('sale_items')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'sale_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'product_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
                'sku_snapshot' => [
                    'type' => 'VARCHAR',
                    'constraint' => 64,
                    'null' => true,
                ],
                'name_snapshot' => [
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                ],
                'unit_price' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'qty' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 1,
                ],
                'discount' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
                'line_total' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('sale_id');
            $this->forge->addKey('product_id');
            $this->forge->addForeignKey('sale_id', 'sales', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'SET NULL');
            $this->forge->createTable('sale_items', true);
        }

        if (!$this->db->tableExists('stock_movements')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'product_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'movement_type' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                ],
                'qty' => [
                    'type' => 'INT',
                    'constraint' => 11,
                ],
                'unit_cost' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'null' => true,
                ],
                'ref_type' => [
                    'type' => 'VARCHAR',
                    'constraint' => 30,
                    'null' => true,
                ],
                'ref_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => true,
                ],
                'reason' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'default' => new RawSql('CURRENT_TIMESTAMP'),
                ],
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('product_id');
            $this->forge->addKey('user_id');
            $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
            $this->forge->createTable('stock_movements', true);
        }
    }

    public function down()
    {
        $this->forge->dropTable('stock_movements', true);
        $this->forge->dropTable('sale_items', true);
        $this->forge->dropTable('sales', true);
        $this->forge->dropTable('products', true);
        $this->forge->dropTable('categories', true);
    }
}

