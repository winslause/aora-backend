<?php
// Printable Menu Page - Can be saved as PDF via browser print
require_once 'database.php';

$sampleMenus = getAllSampleMenus($pdo);
$signatureDishes = getSignatureDishes($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | AORA 45 Restaurant</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Georgia', serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        @media print {
            body {
                padding: 20px;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #2d5a4a;
        }
        
        .header h1 {
            font-size: 36px;
            color: #2d5a4a;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 14px;
            color: #666;
        }
        
        .contact-info {
            text-align: center;
            margin-bottom: 30px;
            font-size: 12px;
            color: #666;
        }
        
        .section {
            margin-bottom: 40px;
        }
        
        .section h2 {
            font-size: 24px;
            color: #2d5a4a;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .menu-block {
            margin-bottom: 30px;
        }
        
        .menu-block h3 {
            font-size: 18px;
            color: #444;
            margin-bottom: 15px;
        }
        
        .menu-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dotted #ddd;
        }
        
        .menu-item:last-child {
            border-bottom: none;
        }
        
        .item-name {
            font-weight: 500;
        }
        
        .item-price {
            color: #2d5a4a;
            font-weight: bold;
        }
        
        .signature-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .signature-item {
            margin-bottom: 20px;
        }
        
        .signature-item h4 {
            font-size: 16px;
            color: #2d5a4a;
            margin-bottom: 5px;
        }
        
        .signature-item p {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .signature-item .price {
            font-size: 16px;
            color: #2d5a4a;
            font-weight: bold;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2d5a4a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #1e4d40;
        }
        
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print / Save as PDF
    </button>
    
    <div class="header">
        <img src="logo1.jpeg" alt="AORA 45 Logo" style="max-width: 150px; height: auto; margin-bottom: 20px;">
        <h1>AORA 45</h1>
        <p>Restaurant & Fine Dining</p>
    </div>
    
    <div class="contact-info">
        <p>Along River Nyandera, Siaya County, Kenya | Tel: +254 769 525 570 | Email: info@aora45.com</p>
    </div>
    
    <?php foreach ($sampleMenus as $menu): ?>
    <div class="section">
        <h2><?php echo htmlspecialchars($menu['title']); ?></h2>
        <?php if (!empty($menu['subtitle'])): ?>
        <p style="margin-bottom: 15px; color: #666; font-style: italic;"><?php echo htmlspecialchars($menu['subtitle']); ?></p>
        <?php endif; ?>
        
        <div class="menu-block">
            <?php foreach ($menu['items'] as $item): ?>
            <div class="menu-item">
                <span class="item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                <span class="item-price"><?php echo htmlspecialchars($item['price']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
    
    <div class="section signature-section">
        <h2>Signature Dishes</h2>
        <?php foreach ($signatureDishes as $dish): ?>
        <div class="signature-item">
            <h4><?php echo htmlspecialchars($dish['name']); ?></h4>
            <p><?php echo htmlspecialchars($dish['description']); ?></p>
            <span class="price">KSh <?php echo number_format($dish['price']); ?></span>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="footer">
        <p>Prices are subject to change without notice.</p>
        <p>&copy; <?php echo date('Y'); ?> AORA 45. All rights reserved.</p>
    </div>
</body>
</html>
