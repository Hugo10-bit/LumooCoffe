<?php
// Default fallback data for cloud / serverless deployment when MySQL is offline

$DEFAULT_CATEGORIES = [
    ['category_id' => 8, 'category_name' => 'Coffee'],
    ['category_id' => 9, 'category_name' => 'Non Coffee'],
    ['category_id' => 7, 'category_name' => 'Sweet'],
    ['category_id' => 6, 'category_name' => 'Light']
];

$DEFAULT_PRODUCTS = [
    [
        'product_id' => 36,
        'category_id' => 8,
        'category_name' => 'Coffee',
        'product_name' => 'Lumo Latte',
        'product_price' => 28000,
        'product_description' => 'Espresso + fresh milk',
        'product_image' => 'produk_1779007130.png',
        'product_status' => 1,
        'is_bestseller' => 1
    ],
    [
        'product_id' => 37,
        'category_id' => 9,
        'category_name' => 'Non Coffee',
        'product_name' => 'Matcha Glow',
        'product_price' => 29000,
        'product_description' => 'Matcha + Fresh milk.',
        'product_image' => 'produk_1779007155.png',
        'product_status' => 1,
        'is_bestseller' => 1
    ],
    [
        'product_id' => 38,
        'category_id' => 7,
        'category_name' => 'Sweet',
        'product_name' => 'Dubai Chewy Cookie',
        'product_price' => 40000,
        'product_description' => 'Chocolate, Pistachio, & Soft Melted Marshmellow',
        'product_image' => 'produk_1779007184.jpg',
        'product_status' => 1,
        'is_bestseller' => 1
    ],
    [
        'product_id' => 52,
        'category_id' => 7,
        'category_name' => 'Sweet',
        'product_name' => 'Soft Cookies',
        'product_price' => 18000,
        'product_description' => 'Rich + soft',
        'product_image' => 'produk_1779082874.jpg',
        'product_status' => 1,
        'is_bestseller' => 1
    ],
    [
        'product_id' => 39,
        'category_id' => 6,
        'category_name' => 'Light',
        'product_name' => 'Chicken Wings',
        'product_price' => 40000,
        'product_description' => 'Chicken wings coated with smoky BBQ sauce',
        'product_image' => 'produk_1779007215.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 42,
        'category_id' => 8,
        'category_name' => 'Coffee',
        'product_name' => 'Caramel Glow',
        'product_price' => 29000,
        'product_description' => 'Espresso + caramel syrup + milk',
        'product_image' => 'produk_1779082114.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 43,
        'category_id' => 8,
        'category_name' => 'Coffee',
        'product_name' => 'Americano',
        'product_price' => 23000,
        'product_description' => 'Espresso + water',
        'product_image' => 'produk_1779082169.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 44,
        'category_id' => 8,
        'category_name' => 'Coffee',
        'product_name' => 'Cold Brew',
        'product_price' => 28000,
        'product_description' => 'Smooth cold coffee',
        'product_image' => 'produk_1779082209.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 45,
        'category_id' => 8,
        'category_name' => 'Coffee',
        'product_name' => 'Cappuccino',
        'product_price' => 27000,
        'product_description' => 'Foamy milk + espresso',
        'product_image' => 'produk_1779082257.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 46,
        'category_id' => 8,
        'category_name' => 'Coffee',
        'product_name' => 'Mocha',
        'product_price' => 30000,
        'product_description' => 'Espresso + chocolate',
        'product_image' => 'produk_1779082294.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 47,
        'category_id' => 9,
        'category_name' => 'Non Coffee',
        'product_name' => 'Milk Tea',
        'product_price' => 26000,
        'product_description' => 'Deep roast oolong tea + milk',
        'product_image' => 'produk_1779082528.png',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 48,
        'category_id' => 9,
        'category_name' => 'Non Coffee',
        'product_name' => 'Strawberry Milk',
        'product_price' => 29000,
        'product_description' => 'Strawberry + milk + cream',
        'product_image' => 'produk_1779082582.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 49,
        'category_id' => 9,
        'category_name' => 'Non Coffee',
        'product_name' => 'Chocolate',
        'product_price' => 29000,
        'product_description' => 'Cocoa + steamed milk',
        'product_image' => 'produk_1779082746.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 50,
        'category_id' => 7,
        'category_name' => 'Sweet',
        'product_name' => 'Cheesecake',
        'product_price' => 33000,
        'product_description' => 'Cheese + creamy',
        'product_image' => 'produk_1779082803.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 51,
        'category_id' => 7,
        'category_name' => 'Sweet',
        'product_name' => 'Croissant',
        'product_price' => 24000,
        'product_description' => 'Butter + flaky',
        'product_image' => 'produk_1779082837.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 53,
        'category_id' => 6,
        'category_name' => 'Light',
        'product_name' => 'Truffle Fries',
        'product_price' => 27000,
        'product_description' => 'French fries + truffle + parmesan',
        'product_image' => 'produk_1779082908.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 54,
        'category_id' => 6,
        'category_name' => 'Light',
        'product_name' => 'Creamy Carbonara',
        'product_price' => 38000,
        'product_description' => 'Pasta + cream sauce + smoked beef + cheese',
        'product_image' => 'produk_1779082969.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ],
    [
        'product_id' => 55,
        'category_id' => 6,
        'category_name' => 'Light',
        'product_name' => 'Chicken Sandwich',
        'product_price' => 33000,
        'product_description' => 'Chicken + lettuce + cheese + toasted bread',
        'product_image' => 'produk_1779082992.jpg',
        'product_status' => 1,
        'is_bestseller' => 0
    ]
];

// Default messages for demo / fallback when database is not connected
$DEFAULT_MESSAGES = [
    [
        'id' => 1,
        'nama' => 'Dimas Pratama',
        'email' => 'dimas.pratama@gmail.com',
        'telepon' => '081298765432',
        'pesan' => 'Kopi Lumo Latte rasanya mantap banget! Apakah ada promo atau voucher membership bulanan untuk mahasiswa?',
        'created_at' => '2026-11-20 14:32:00'
    ],
    [
        'id' => 2,
        'nama' => 'Siti Rahmawati',
        'email' => 'siti.rahma@yahoo.com',
        'telepon' => '082155443322',
        'pesan' => 'Halo min, untuk Dubai Chewy Cookie apakah ready stock setiap hari di outlet Malang? Mau pesan untuk acara kantor.',
        'created_at' => '2026-11-21 09:15:00'
    ],
    [
        'id' => 3,
        'nama' => 'Kevin Alexander',
        'email' => 'kevin.alex@outlook.com',
        'telepon' => '087811223344',
        'pesan' => 'Tempatnya cozy dan wifi kencang. Saran untuk menu Matcha Glow bisa ditambah pilihan less sweet.',
        'created_at' => '2026-11-21 16:45:00'
    ]
];

function get_app_categories($conn) {
    global $DEFAULT_CATEGORIES;
    if ($conn) {
        $res = @mysqli_query($conn, "SELECT * FROM tb_category ORDER BY FIELD(category_name, 'Coffee', 'Non Coffee', 'Sweet', 'Light') ASC, category_id ASC");
        if ($res && mysqli_num_rows($res) > 0) {
            $list = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $list[] = $row;
            }
            return $list;
        }
    }
    return $DEFAULT_CATEGORIES;
}

function get_app_bestsellers($conn, $limit = 4) {
    global $DEFAULT_PRODUCTS;
    if ($conn) {
        $res = @mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 AND is_bestseller > 0 ORDER BY is_bestseller DESC LIMIT " . (int)$limit);
        if ($res && mysqli_num_rows($res) > 0) {
            $list = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $list[] = $row;
            }
            return $list;
        }
    }
    // Fallback bestsellers
    $bestsellers = array_filter($DEFAULT_PRODUCTS, function($item) {
        return !empty($item['is_bestseller']);
    });
    return array_slice(array_values($bestsellers), 0, $limit);
}

function get_app_products($conn) {
    global $DEFAULT_PRODUCTS;
    if ($conn) {
        $res = @mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) WHERE product_status = 1 ORDER BY product_id DESC");
        if ($res && mysqli_num_rows($res) > 0) {
            $list = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $list[] = $row;
            }
            return $list;
        }
    }
    return $DEFAULT_PRODUCTS;
}

function get_app_total_products($conn) {
    global $DEFAULT_PRODUCTS;
    if ($conn) {
        $res = @mysqli_query($conn, "SELECT COUNT(*) FROM tb_product WHERE product_status = 1");
        if ($res) {
            $row = mysqli_fetch_row($res);
            return (int)$row[0];
        }
    }
    return count($DEFAULT_PRODUCTS);
}

function get_admin_categories($conn) {
    global $DEFAULT_CATEGORIES;
    if ($conn) {
        $res = @mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
        if ($res && mysqli_num_rows($res) > 0) {
            $list = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $list[] = $row;
            }
            return $list;
        }
    }
    return $DEFAULT_CATEGORIES;
}

function get_admin_products($conn) {
    global $DEFAULT_PRODUCTS;
    if ($conn) {
        $res = @mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) ORDER BY product_id DESC");
        if ($res && mysqli_num_rows($res) > 0) {
            $list = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $list[] = $row;
            }
            return $list;
        }
    }
    return $DEFAULT_PRODUCTS;
}

function get_admin_messages($conn) {
    global $DEFAULT_MESSAGES;
    if ($conn) {
        $res = @mysqli_query($conn, "SELECT * FROM tb_message ORDER BY id DESC");
        if ($res && mysqli_num_rows($res) > 0) {
            $list = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $list[] = $row;
            }
            return $list;
        }
    }
    return $DEFAULT_MESSAGES;
}

function get_admin_bestseller_count($conn) {
    global $DEFAULT_PRODUCTS;
    if ($conn) {
        $res = @mysqli_query($conn, "SELECT COUNT(*) FROM tb_product WHERE is_bestseller = 1");
        if ($res) {
            $row = mysqli_fetch_row($res);
            return (int)$row[0];
        }
    }
    $count = 0;
    foreach ($DEFAULT_PRODUCTS as $p) {
        if (!empty($p['is_bestseller'])) {
            $count++;
        }
    }
    return $count;
}
