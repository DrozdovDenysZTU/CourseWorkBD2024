<?php
class StatsModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAvgRatingPerProduct()
    {
        $stmt = $this->db->query("CALL Stats_AvgRatingPerProduct()");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopSellingProducts()
    {
        $stmt = $this->db->query("CALL Stats_TopSellingProducts()");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopUsersByReviews()
    {
        $stmt = $this->db->query("CALL Stats_TopUsersByReviews()");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
