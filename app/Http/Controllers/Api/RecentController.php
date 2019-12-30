<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Follow;
use App\Http\Controllers\Controller;
use App\Like;
use App\Post;
use App\Recent;
use App\Student;
use Illuminate\Http\Request;

class RecentController extends Controller
{
    //
    public function get($id, Request $request)
    {
        $student=Student::where('phone_number', $id)->first();
        $header=$request->bearerToken();
        if ($header!=$student->api_token)
        {
            return response('error in authorization', 422);
        }
        $posts = Post::where('student_id', $id)->get();
        for ($i = 0; $i < $posts->count(); $i++)
        {
            $posts_id[$i]=$posts[$i]->id;
            $like[]=Like::where('post_id', $posts_id[$i])->first();
            $comment[]=Comment::where('post_id', $posts_id[$i])->get();
        }
        $follow=Follow::where('following_id', $id)->get();
        $recent=new Recent();
        for ($j=0; $j<count($like);$j++){
            $recent->action='like';
            $recent->action_id=$like[$j]->like_id;
            $recent->post_id=$like[$j]->post_id;
            $recent->student_id=$like[$j]->student_id;
            $recent->created_at=$like[$j]->created_at;
            $recents[$j]=$recent;
        }

        for ($m=0;$m<count($comment);$m++)
        {
            for ($n=0;$n<count($comment[$m]);$n++){
                $recentc=new Recent();
                $recentc->action='comment';
                $recentc->action_id=$comment[$m][$n]->comment_id;
                $recentc->post_id=$comment[$m][$n]->post_id;
                $recentc->student_id=$comment[$m][$n]->student_id;
                $recentc->created_at=$comment[$m][$n]->created_at;
               // return $comment[$m][$n];
                array_push($recents, $recentc);
                unset($recentc);
            }

        }

        for ($z=0;$z<count($follow);$z++)
        {
            $recentf=new Recent();
            $recentf->action='follow';
            $recentf->student_id=$follow[$z]->follower_id;
            $recentf->created_at=$follow[$z]->created_at;
            array_push($recents, $recentf);
        }
        return response()->json($recents, 200);

    }
}
