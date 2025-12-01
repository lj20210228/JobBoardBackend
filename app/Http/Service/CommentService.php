<?php

namespace App\Http\Service;

use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CommentService
{
    public function addComment(array $data):Comment{
        return Comment::create(
            [
                'user_id'=>$data['user_id'],
                'comment'=>$data['comment'],
                'company_id'=>$data['company_id'],
                'rating'=>$data['rating']
            ]
        );
    }
    public function updateComment(Comment $comment,array $data):Comment{
        $comment->update($data);
        return $comment;
    }
    public function deleteComment(Comment $comment):bool{
        return $comment->delete();
    }
    public function getComment( $commentId):?Comment{
        return Comment::where('id',$commentId)->first();
    }
    public function getCommentsForUser($userId):Collection{
      return Comment::where("user_id",$userId)->get();

    }
    public function getCommentsForCompany($companyId):LengthAwarePaginator{
        return Comment::where("company_id",$companyId)->
            paginate(5);
    }
    public function getAverageRatingForCompany($companyId):float{
        return (float) Comment::where('company_id', $companyId)->avg('rating') ?? 0;

    }



}
