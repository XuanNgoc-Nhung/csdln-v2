<?php
/**
 * Created by PhpStorm.
 * User: daua1993
 * Date: 13/10/2017
 * Time: 08:12
 */

namespace App\Connection;

use App\Exceptions\TokenExpireException;
use GuzzleHttp\Client;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\StreamInterface;

class ConnectionHelper
{

    /**
     * @var bool Xac dinh xem co in thong tin request ra khong
     */
    private $print = true;
    private $httpRequest;

    public function getInt()
    {
        return 3453453;
    }

    public function setRequest($req)
    {
        $this->httpRequest = $req;
    }


    public function requestApi($uri,$method,array $options = []){
        $client = new Client([
            'headers' => ['Accept-Encoding' => 'gzip','Content-Type' => 'application/json','charset' => 'utf-8']
        ]);
        try{
            $response = $client->request($method,$uri,$options);
        }
        catch (ClientException $e) {
           // Log::info("ClientException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (ServerException $e) {
           // Log::info("ServerException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (GuzzleException $e) {
           // Log::info("ClientException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (\Exception $e) {
           // Log::info("Exception: " . $e->getMessage());
        }

        if ($response != null) {
            $body = $response->getBody();
            if ($body != null) {
                $result = json_decode($body->getContents());
                return $result;
            }
        }
        return null;
    }

    /** Ham GET
     * @param $url
     * @param $params
     * @param bool $add_token
     * @return mixed|null
     */
    public function doGet($url, $params, $add_token = false)
    {
        $client = new Client();
        $response = null;
       // Log::info("url call = " . $url);
        try {
            if ($this->print) {
                $this->printUrl("GET", $url, $params);
            }
            $response = $client->request('GET', $url, [
                'query' => $params,
                'headers' => $this->getDefaultParams(),
            ]);

        } catch (ClientException $e) {
           // Log::info("doGet ClientException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (ServerException $e) {
           // Log::info("doGet ServerException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (GuzzleException $e) {
           // Log::info("doPost ClientException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (\Exception $e) {
           // Log::info("doGet Exception: " . $e->getMessage());
        }
       // Log::info("response");
        if ($response != null) {
            $body = $response->getBody();
            if ($body != null) {
                $result = json_decode($body->getContents(), true);
                return $result;
            }
        }
        return null;
    }

    /**Ham POST
     * @param $url
     * @param $params
     * @param bool $add_token
     * @param int $timeout
     * @return mixed|null
     */
    public function doPost($url, $params, $add_token = false, $timeout = 30)
    {
        $client = new \GuzzleHttp\Client(['timeout' => $timeout]);
        $response = null;

        // Log::info("POST : " . $url . " data: " . json_encode($params, JSON_PRETTY_PRINT));
        // Log::info(microtime(true));
        try {
            $response = $client->request('POST', $url, [
                'json' => $params,
                'headers' => $this->getDefaultParams(),
            ]);
            // Log::info("Hứng được ở 1:");
        } catch (ClientException $e) {
            // Log::info("doPost ClientException: " . $e->getMessage());
            // Log::info("Hứng được ở 2:");
            $response = $e->getResponse();
        } catch (ServerException $e) {
            // Log::info("doPost ServerException: " . $e->getMessage());
            // Log::info("Hứng được ở 3:");
            $response = $e->getResponse();
        } catch (GuzzleException $e) {
            // Log::info("doPost ClientException: " . $e->getMessage());
            $response = $e->getResponse();
            // Log::info("Hứng được ở 4:");
        } catch (\Exception $e) {
            // Log::info("doPost Exception: " . $e->getMessage());

            // Log::info("Hứng được ở 5:");
        }
        // Log::info(microtime(true));
        // Log::info(json_encode($response));
        // Log::info("response ở bên trênn");
        if ($response != null) {
            $body = $response->getBody();
            if ($body != null) {
                try{
                    $result = json_decode($body->getContents(), true);
                    if(!$result) throw new \Exception();
                }catch(\Exception $e){
                    // bổ sung đường dần file. sau này check api nào gọi rồi trả về file
                    $filepath=(string)$body;
                    $result = [
                        "rc" => 0,
                        "rd" => "",
                        // "file" => base64_encode($body)
                        "file" => $filepath
                    ];
                }
                return $result;
            }
        }
        return null;
    }

    /** Ham PUT
     * @param $url
     * @param $params
     * @param bool $add_token
     * @return mixed|null
     */
    public function doPut($url, $params, $add_token = false)
    {
        $client = new \GuzzleHttp\Client();
        $response = null;
        Log:info($url);
       // Log::info("PUT : " . $url . " data: " . json_encode($params, JSON_PRETTY_PRINT));

        try {
            if ($this->print) {
                //$this->printUrl("PUT", $url, $params);
            }
            $response = $client->request('PUT', $url, [
                'json' => $params,
                'headers' => $this->getDefaultParams(),
            ]);
        } catch (ClientException $e) {
           // Log::info("doPut ClientException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (ServerException $e) {
           // Log::info("doPut ServerException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (\Exception $e) {
           // Log::info("doPut Exception: " . $e->getMessage());
        }
        if ($response != null) {
            $body = $response->getBody();
            if ($body != null) {
                $result = json_decode($body->getContents(), true);
//                $this->checkLogin($result);
                return $result;
            }
        }
        return null;
    }

    /** Ham DELETE
     * @param $url
     * @param $params
     * @param bool $add_token
     * @return mixed|null
     */
    public function doDelete($url, $params, $add_token = false)
    {
        $client = new \GuzzleHttp\Client();

       // Log::info("DELETE : " . $url . " data: " . json_encode($params, JSON_PRETTY_PRINT));

        $response = null;
        try {
//            if ($this->print) {
//                $this->printUrl("DELETE", $url, $params);
//            }
            $response = $client->request('DELETE', $url, [
                'json' => $params,
                'headers' => $this->getDefaultParams(),
            ]);
        } catch (ClientException $e) {
           // Log::info("doDelete ClientException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (ServerException $e) {
           // Log::info("doDelete ServerException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (\Exception $e) {
           // Log::info("doDelete Exception: " . $e->getMessage());
        }
        //dd($response);
        if ($response != null) {
            $body = $response->getBody();
            if ($body != null) {
                $result = json_decode($body->getContents(), true);
//                $this->checkLogin($result);
                return $result;
            }
        }
        return null;
    }

    /** Ham get tra ve json object
     * @param $url
     * @param $params
     * @param bool $add_token
     * @return mixed|null
     */
    public function doGetJsonObject($url, $params, $add_token = false)
    {
        $client = new Client();
        $response = null;
        try {
            if ($this->print) {
                $this->printUrl("GET", $url, $params);
            }
            $response = $client->request('GET', $url, [
                'query' => $params,
                'headers' => $this->getDefaultParams(),
            ]);
        } catch (ClientException $e) {
           // Log::info("doGetJsonObject ClientException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (ServerException $e) {
           // Log::info("doGetJsonObject ServerException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (\Exception $e) {
           // Log::info("doGetJsonObject Exception: " . $e->getMessage());
        }
        if ($response != null) {
            $body = $response->getBody();
            if ($body != null) {
                return json_decode($body->getContents(), true);
            }
        }
        return null;
    }

    /** Ham post tra ve json object
     * @param $url
     * @param $params
     * @param bool $add_token
     * @return mixed|null
     */
    public function doPostJsonObject($url, $params, $add_token = false)
    {
        $client = new \GuzzleHttp\Client();
        $response = null;
       Log::info("Post data : " . $url . " data: " . json_encode($params, JSON_PRETTY_PRINT));
        try {
            if ($this->print) {
                //$this->printUrl("POST", $url, $params);
            }
            $response = $client->request('POST', $url, [
                'json' => $params,
                'headers' => $this->getDefaultParams(),
            ]);
        } catch (ClientException $e) {
//            dd($e);
           Log::info("doPostJsonObject ClientException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (ServerException $e) {
           Log::info("doPostJsonObject ServerException: " . $e->getMessage());
            $response = $e->getResponse();
        } catch (\Exception $e) {
           Log::info("doPostJsonObject Exception: " . $e->getMessage());
        }
        if ($response != null) {
            $body = $response->getBody();
            if ($body != null) {
                return json_decode($body->getContents(), null);
            }
        }
        return null;
    }

    /** Ham lay cac params default de dong di
     * @return array
     */
    private function getDefaultParams()
    {
        $defaults = array();
        if (is_login()) {
            $xForwardedFor = session('xForwardedFor');
            $UserAgent = session('UserAgent');
            $defaults["X-FORWARDED-FOR"] = $xForwardedFor;
            $defaults["User-Agent"] =$UserAgent;
            $defaults["token"] = get_user_info("token");
            // Log::info("Token: " . get_user_info("token"));
            // Log::info("xForwardedFor: " . $xForwardedFor);
            // Log::info("UserAgent: " . $UserAgent);
        }
        return $defaults;
    }

    private function checkLogin($data)
    {
//        dd($data);
        if (!empty($data['code']) && ($data['code'] == 409 || $data['code'] == 401)) {
            session(['isLoggedIn' => false]);
            throw new TokenExpireException();
        }
    }

    /** In ra link cac request
     * @param $method
     * @param $url
     * @param $params
     */
    private function printUrl($method, $url, $params)
    {
        $str = $method . " : " . $url;
        $str .= "?";
        foreach ($params as $key => $value) {
            $str .= $key . "=" . $value . "&";
        }
       // Log::info($str);
    }

    public function uploadImage($files, $description, $gymId, $branchId)
    {

        if (!isset($files) || count($files) == 0) {
            return null;
        }

       // Log::info("upload [" . count($files) . "] image with desc= " . $description . " from gym[" . $gymId . "]");


        //$url = "http://103.56.158.146:8889/cdn/upload";
        $url = config("url.api_image_upload_execute");
       // Log::info("url: " . $url);
        $client = new Client();
        $response = null;
        $json = null;
        $dataUpload = array();
        try {
            foreach ($files as $file) {
                $upload = array(
                    'name' => 'files',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
            $dataUpload[] = array('name' => 'gymId', 'contents' => $gymId);
            $dataUpload[] = array('name' => 'branch', 'contents' => $branchId);
            $dataUpload[] = array('name' => 'description', 'contents' => $description);

            $header = $this->getDefaultParams();
            $header['X-User-Id'] = '1507603258539';

            $response = $client->post($url, [
                'multipart' => $dataUpload,
                'headers' => $header,
            ]);

            if ($response != null) {
                $body = $response->getBody();
                if ($body != null) {
                    $json = json_decode($body->getContents(), true);
                }
            }
        } catch (\Exception $exception) {
           // Log::info("Error: " . $exception);
        }

        return $json;
    }

    public function create(Request $request)
    {
        if ($request->hasFile("imgUrl")) {
            $prepareFiles = [];
            if ($files = $request->file('imgUrl')) {
                foreach ($files as $file) {
                    $file_name = $file->getClientOriginalName();
                    $file_path = $file->getRealPath();
                    $upload = array(
                        'name' => $file_name,
                        'path' => $file_path,
                    );
                    $prepareFiles[] = $upload;
                }
            }
            $gymid = get_user_info("gym_id");
            $branchid = get_user_info("gym_branch_id");
            $json = $this->uploadImage($prepareFiles, "Test upload image", $gymid, $branchid);
            dd($json);
        } else {

        }
    }

}
