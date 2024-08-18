<?php
namespace App\Controller;
use App\Entity\Post;
use followed\framed\Http\Response;
use followed\framed\Controller\AbstractController;
use App\Repo\PostMapper;
use App\Repo\PostRepo;
class PostController extends AbstractController
{
    public function __construct(private PostMapper $postMapper, private PostRepo $postRepository)
    {
    }
    public function show(int $id):Response{
        $post = $this->postRepository->findOrFail($id);

        return $this->render('post.html.twig', [
            'post' => $post
        ]);
    }
    public function create():Response
    {
        return $this->render('create_post.html.twig');
    }

    public function store(): void
    {
        $title = $this->request->postParams['title'];
        $body = $this->request->postParams['body'];
        $post = Post::create($title, $body);
        
        $this->postMapper->save($post);
        dd($post);
    }
}