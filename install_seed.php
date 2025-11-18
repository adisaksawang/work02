<?php
require 'inc/config.php';
try {
    // check tables
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'"); $exists = $stmt->fetchColumn();
    if(!$exists){
        // import schema
        $sql = file_get_contents(__DIR__ . '/sql/schema.sql');
        $pdo->exec($sql);
    }
    $stmt = $pdo->query('SELECT COUNT(*) FROM users');
    $c = $stmt->fetchColumn();
    if($c > 0){
        echo 'Seed already ran (users exist).';
        exit;
    }
    // create users
    $users = [
        ['Admin','admin@example.com','1234','admin'],
        ['Seller','seller@example.com','1234','seller'],
        ['User','user@example.com','1234','user'],
    ];
    $ins = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
    foreach($users as $u){
        $ins->execute([$u[0], $u[1], password_hash($u[2], PASSWORD_DEFAULT), $u[3]]);
    }
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?'); $stmt->execute(['seller@example.com']); $seller_user_id = $stmt->fetchColumn();
    if($seller_user_id){
        $pdo->prepare('INSERT INTO sellers (user_id,shop_name,description,approved) VALUES (?,?,?,1)')->execute([$seller_user_id,'ohm i phoneShop','ร้านตัวอย่าง ohm',1]);
        $seller_id = $pdo->lastInsertId();
        $phones = [
            ['iPhone 15 Pro','iPhone 15 Pro - 128GB',36900,10,'assets/img/iPhone_13_.jpg'],
            ['iPhone 14 ','iPhone14 - 256GB',21900,8,'assets/img/iphone2.jpg'],
            ['iPhone 13','iPhone 13 - 256GB',18900,12,'assets/img/iphone3.jpg'],
            ['iPhone 12','iPhone 12 - 256GB',15900,5,'assets/img/iphone4.jpg'],
            ['iPhone 16','iPhone16 - 256GB',38900,7,'assets/img/iphone5.jpg'],
        ];
        $pstmt = $pdo->prepare('INSERT INTO products (seller_id,title,description,price,stock,image,published) VALUES (?,?,?,?,?,?,1)');
        foreach($phones as $ph){ $pstmt->execute([$seller_id,$ph[0],$ph[1],$ph[2],$ph[3],$ph[4]]); }
    }
    echo 'Seed complete. Accounts:\nAdmin admin@example.com / 1234\nSeller seller@example.com / 1234\nUser user@example.com / 1234';
} catch(Exception $e){
    echo 'Error: ' . $e->getMessage();
}
