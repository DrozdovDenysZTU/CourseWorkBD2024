<?php
require_once __DIR__ . '/../models/ReviewModel.php';

class ReviewController
{
    private $basePath = '/Backend/online_bag_store/public';

    private function redirectTo($path)
    {
        header("Location: {$this->basePath}{$path}");
        exit;
    }

    public function add()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirectTo('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $rating = $_POST['rating'];
            $reviewText = $_POST['review_text'];
            $userId = $_SESSION['user']['UserID'];

            $reviewModel = new ReviewModel();
            $reviewModel->addReview($userId, $productId, $rating, $reviewText);

            $_SESSION['message'] = 'Відгук додано!';
            $this->redirectTo("/product/detail/$productId");
        }
    }

    public function manage()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] != 'admin') {
            $this->redirectTo('/login');
        }

        $reviewModel = new ReviewModel();

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $reviewsPerPage = 10;

        $totalReviews = $reviewModel->countReviews();
        $totalPages = ceil($totalReviews / $reviewsPerPage);

        $reviews = $reviewModel->getReviewsByPage($currentPage, $reviewsPerPage);

        include(__DIR__ . '/../views/admin/reviews.php');
    }

    public function delete($id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] != 'admin') {
            $this->redirectTo('/login');
        }

        $reviewModel = new ReviewModel();
        $reviewModel->deleteReview($id);

        $_SESSION['message'] = 'Відгук видалено!';
        $this->redirectTo('/admin/reviews');
    }

    public function approve($id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] != 'admin') {
            $this->redirectTo('/login');
        }

        $reviewModel = new ReviewModel();
        $reviewModel->approveReview($id);

        $_SESSION['message'] = 'Відгук схвалено!';
        $this->redirectTo('/admin/reviews');
    }

    public function reject($id)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] != 'admin') {
            $this->redirectTo('/login');
        }

        $reviewModel = new ReviewModel();
        $reviewModel->rejectReview($id);

        $_SESSION['message'] = 'Відгук відхилено!';
        $this->redirectTo('/admin/reviews');
    }
}
