//Developed by João Marcos -> https://github.com/joaomarcosaf/
<?php
// Exportação de produtos ativos e suas categorias
require_once 'app/Mage.php';
umask(0);
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=produtos-categorias-seton.csv');
$output = fopen('php://output', 'w');
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$userModel = Mage::getModel('admin/user');
$userModel->setUserId(0);
$collection = Mage::getModel('catalog/product')
 ->getCollection()
 ->addAttributeToFilter('status', 1)
 ->addAttributeToSelect('*');
foreach($collection as $product) {
  $_cat = array();
  $categoryName = array();
  $sku = $product->getSku();

  foreach ($product->getCategoryIds() as $Id) {
  $_cat = Mage::getModel('catalog/category')->setStoreId(Mage::app()->getStore()->getId())->load($Id);
   $categoryName[] = $_cat->getName();
  }
  $comma_separated = implode(",", $categoryName);
    fputcsv($output, array($sku, $comma_separated)
    );
}
?>
