<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Brand;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function index(Request $request)
    {
        $body = json_decode($request->getContent());
        switch ($body->type) {
            case 'message':
                return $this->message($body->payload);
                break;
            default:
                # code...
                break;
        }
        
    }
    private function message($payload)
    {
        $customer = Customer::where('phone_number', $payload->sender->phone)->first();
        if($customer === null)
        {
            $customer = Customer::create([
                'name'=>$payload->sender->name,
                'phone_number' => $payload->sender->phone,
                'customer_id' => \Str::random(8, true),
                'code' => rand(100000,999999),
                'code_changed_at'=> new DateTime('NOW')
            ]);
            $response = 'Hello '.$customer->name.', Welcome!';
            $this->api_chatbot_universal_gateway($response, $customer, 'text', 'start');
            $categoryTemplate = $this->getCategoriesTemplate();
            return $this->api_chatbot_universal_gateway($categoryTemplate, $customer, 'text', 'wt-category');
            
        }
        switch ($payload->type) {
            case 'text':
                return $this->checkAndReply($payload->payload->text, $customer);
                break;
            default:
                #code ...
                break;
        }
        return response()->json($payload, 200);
    }
    private function api_chatbot_universal_gateway($postdata,$customer,$type, $status, $text = '')
    {
        $body = [
            "apikey" =>"c9b0dd70-b0ff-4ce8-9c9d-a3bbb2947fe5",
            "sender" => "233506758586",
            "destination" => $customer->phone_number,
            "botname" => "GreateCommissionOfGhana"
        ];
        switch($type)
        {
            case 'template':
                $body["message"] = $postdata;
                $url = 'https://api.chatbotsghana.com/api/send/text/msg/template';
                break;
            case 'text':
                $body["message"] = $postdata;
                $url = 'https://api.chatbotsghana.com/api/send/text/msg';
                break;
            case 'image':
                $body["imageUrl"] = $postdata->imageUrl?? 'No Image URL';
                $body["caption"] = $postdata->caption?? '';
                $url = 'https://api.chatbotsghana.com/api/send/image/msg';
                break;
            case 'video':
                $body["videoUrl"] = $postdata->videoUrl??'No Video URL';
                $body["caption"] = $postdata->caption??'';
                $url = 'https://api.chatbotsghana.com/api/send/video/msg';
                break;
            case 'file':
                $body["fileURL"] = $postdata->fileURL??'No File URL';
                $body["filename"] = $postdata->filename??'No file name';
                $url = 'https://api.chatbotsghana.com/api/send/file/msg';
                break;
            case 'audio':
                $body["audioURL"] = $postdata->audioURL??'No Audio URL';
                $url = 'https://api.chatbotsghana.com/api/send/audio/msg';
                break;
            case 'location':
                $body["latitude"] = $postdata->latitude?? '';
                $body["longitude"] = $postdata->longitude??'';
                $body["name"] = $postdata->name??'';
                $body["address"] = $postdata->address??'';
                $url = 'https://api.chatbotsghana.com/api/send/location/msg';
                break;
            case 'optin':
                $url = 'https://api.chatbotsghana.com/api/send/optin/msg';
                break;
            case 'optout':
                $url = 'https://api.chatbotsghana.com/api/send/optout/msg';
                break;
            case 'users':
                $url = 'https://api.chatbotsghana.com/api/send/users/msg';
                break;
            default:
                $url = null;
    
        }
        if($body &&  $url){
            // $curl = curl_init();
            //     curl_setopt_array($curl, array(
            //     CURLOPT_URL => $url,
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => "",
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 300,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => "POST",
            //     CURLOPT_POSTFIELDS => json_encode($body),
            //     CURLOPT_HTTPHEADER => array(
            //         "Content-Type: application/json"
            //     ),
            // ));
            // //dd($curl);
            // $response = curl_exec($curl);
            // $err = curl_error($curl);
            // curl_close($curl);
            
            // // $this->writelog("Send Template Message Gateway Response: ".$response."\n",1);
            // $response = json_decode($response, true);
            // dd($response);
            // if(!$err){
            //     return $response;
            // }else{
            //     return "error";
            // }
            $customer->responses()->create([
                'type' => $type,
                'status' => $status,
                'text' => $text
            ]);
            return response()->json($body, 200);
        }else{
            return "empty";
        }
    }

    private function checkAndReply($text, $customer)
    {
        $lastRes = $customer->responses()->orderBy('id', 'desc')->get()->first();
        switch ($lastRes->type)
        {
            case 'text':
            return $this->textTypeReply($text, $customer, $lastRes->status, /**$lastRes->text*/ 'phone');
                break;
            default:
                # code...
                break;
        }
    }

    private function textTypeReply($text, $customer, $status, $reqText)
    {
        if(strtolower($text) == 'restart')
        {
            $categoryTemplate = $this->getCategoriesTemplate();
            return $this->api_chatbot_universal_gateway($categoryTemplate, $customer, 'text', 'wt-category');
        }
        switch ($status) {                
            case 'wt-category':
                try {
                    $message = $this->checkAndGetCategoryBrands($text);
                    return $this->api_chatbot_universal_gateway($message, $customer, 'text', 'wt-brand',$text);
                } catch (\Throwable $th) {
                    return $this->api_chatbot_universal_gateway("Sorry Cannot find brand $text", $customer, 'text', 'wt-category');
                }
                break;
            case 'wt-brand':
                try {
                    $message = $this->checkAndGetBrandProducts($text,$reqText);
                    return $this->api_chatbot_universal_gateway($message, $customer, 'text', 'wt-product', $text);
                } catch (\Throwable $th) {
                    // return $this->api_chatbot_universal_gateway("Sorry Cannot find product $text", $customer, 'text', 'wt-brand');
                    throw $th;
                }
                break;
            default:
                # code...
                break;
        }
    }

    private function getCategoriesTemplate($start=0)
    {
        $message ="*Here are some of our categories*\n";
        $categories = Category::all();
        foreach ($categories as $category) {
            $message .= "*$category->name*\n";
        }
        return $message;
    }

    private function checkAndGetCategoryBrands($text)
    {


        $QUERY = "SELECT * FROM categories WHERE SIMILARITY(name, '$text') > 0.1 limit 6";
        
        try {
            $categoryQuery = DB::select($QUERY)[0];
        } catch (\Throwable $th) {
            throw $th;
        }
        $message ="*Here are our $categoryQuery->name brands*\n";
        $brands = Category::where('name', $categoryQuery->name)->first()->brands;

        foreach ($brands as $brand) {
            $message .= "*$brand->name*\n";
        }

        return $message;
        
    }
    private function checkAndGetBrandProducts($text, $reqText)
    {


        $QUERY_BRAND = "SELECT * FROM brands WHERE SIMILARITY(name, '$text') > 0.3 limit 6";
        $QUERY_CATEGORY = "SELECT * FROM categories WHERE SIMILARITY(name, '$reqText') > 0.1 limit 6";
        
        try {
            $brandQuery = DB::select($QUERY_BRAND)[0];
        } catch (\Throwable $th) {
            throw $th;
        }
        $categoryQuery = DB::select($QUERY_CATEGORY)[0];
        $message ="*Here are our $brandQuery->name $categoryQuery->name brands*\n";
        $productsUnFiltered = Brand::where('name', $brandQuery->name)->first()->products()->get();
        $products = [];
        foreach ($productsUnFiltered as $product) {
            if($product->categories->where('id',$categoryQuery->id)->first())
            {
                if(
                    $product->brands_id === $brandQuery->id && 
                    $product->categories->where('id',$categoryQuery->id)->first()->id === $categoryQuery->id
                ){ 
                    array_push($products, $product);
                }
            }
        }
        foreach ($products as $product) {
            $message .= "*$product->name*\n";
        }

        return $message;
        
    }
}
    