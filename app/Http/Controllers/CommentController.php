<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Service\CommentService;
use App\Http\Service\CompanyService;
use App\Http\Service\UserService;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected CommentService $commentService;
    protected CompanyService $companyService;
    public function __construct(CommentService $commentService, CompanyService $companyService)
    {
        $this->commentService = $commentService;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'comment'=>'required',
            'rating'=>'required|numeric',
            'company_id'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $company=$this->companyService->getCompanyById($request->get('company_id'));
        if(!$company){
            return response()->json(['message'=>'Company not found'],404);
        }
        $userId=$request->user()->id;
        $data = $request->only(['comment', 'rating', 'company_id']);
        $data['user_id'] = $userId;
        $comment=$this->commentService->addComment($data);

        return response()->json(["comment"=>new CommentResource($comment)],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $commentUpdated = $this->commentService->updateComment($comment, $request->toArray());
        return response()->json(["comment"=>new CommentResource($commentUpdated),'message'=>"Comment successfully updated"],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->commentService->deleteComment($comment);
        return response()->json(['message'=>"Comment successfully deleted"],201);
    }
    public function getCommentsForUser(Request $request){
        $userId=$request->user()->id;
        $comments=$this->commentService->getCommentsForUser($userId);
        return response()->json(["comments"=>CommentResource::collection($comments),'message'=>"Comments founded successfully"],201);
    }
    public function getCommentsForCompany($companyId){
        $comments=$this->commentService->getCommentsForCompany($companyId);
        return response()->json(["comments"=>CommentResource::collection($comments)],200);

    }

}
