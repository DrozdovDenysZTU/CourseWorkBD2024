<?php
class ReviewModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getReviewsByProduct($productId)
    {
        $stmt = $this->db->prepare("SELECT r.*, u.Username 
                                   FROM Reviews r 
                                   JOIN Users u ON r.UserID = u.UserID 
                                   WHERE r.ProductID = :productId 
                                   ORDER BY r.ReviewDate DESC");
        $stmt->execute([':productId' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addReview($userId, $productId, $rating, $reviewText)
    {
        $stmt = $this->db->prepare("INSERT INTO Reviews (ProductID, UserID, Rating, ReviewText, ReviewDate, Status) 
                                   VALUES (:productId, :userId, :rating, :reviewText, CURDATE(), 'pending')");
        return $stmt->execute([
            ':productId' => $productId,
            ':userId' => $userId,
            ':rating' => $rating,
            ':reviewText' => $reviewText
        ]);
    }

    public function getAverageRating($productId)
    {
        $stmt = $this->db->prepare("SELECT AVG(Rating) as avgRating FROM Reviews WHERE ProductID = :productId");
        $stmt->execute([':productId' => $productId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['avgRating'] ? round($result['avgRating'], 1) : 0;
    }

    public function getAllReviews()
    {
        $stmt = $this->db->query("SELECT r.*, u.Username, p.ProductName 
                                 FROM Reviews r 
                                 JOIN Users u ON r.UserID = u.UserID 
                                 JOIN Products p ON r.ProductID = p.ProductID 
                                 ORDER BY r.ReviewDate DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countReviews()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM Reviews");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getReviewsByPage($page, $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare("SELECT r.ReviewID, p.ProductName, u.Username, r.Rating, r.ReviewDate, r.Status 
                                    FROM Reviews r
                                    JOIN Products p ON r.ProductID = p.ProductID
                                    JOIN Users u ON r.UserID = u.UserID
                                    ORDER BY r.ReviewDate DESC
                                    LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approveReview($reviewId)
    {
        $stmt = $this->db->prepare("UPDATE Reviews SET Status = 'approved' WHERE ReviewID = :reviewId");
        return $stmt->execute([':reviewId' => $reviewId]);
    }

    public function rejectReview($reviewId)
    {
        $stmt = $this->db->prepare("UPDATE Reviews SET Status = 'rejected' WHERE ReviewID = :reviewId");
        return $stmt->execute([':reviewId' => $reviewId]);
    }

    public function deleteReview($reviewId)
    {
        $stmt = $this->db->prepare("DELETE FROM Reviews WHERE ReviewID = :reviewId");
        return $stmt->execute([':reviewId' => $reviewId]);
    }
}
