-- Perbaikan typo data produk Lumoo Coffee.
-- Jalankan juga di database hosting (phpMyAdmin InfinityFree) supaya data online ikut terkoreksi.

UPDATE tb_product SET product_name = 'Strawberry Milk' WHERE product_id = 48;
UPDATE tb_product SET product_description = 'Pasta + cream sauce + smoked beef + cheese' WHERE product_id = 54;
UPDATE tb_product SET product_name = 'Cappuccino' WHERE product_id = 45;
UPDATE tb_product SET product_description = 'Butter + flaky' WHERE product_id = 51;
