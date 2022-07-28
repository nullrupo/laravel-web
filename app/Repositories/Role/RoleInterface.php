<?php
namespace App\Repositories\Book;

use App\Repositories\RepositoryInterface;

interface BookRepositoryInterface extends RepositoryInterface
{
    //ví dụ: lấy 5 sản phầm đầu tiên
    public function getProduct();
}
