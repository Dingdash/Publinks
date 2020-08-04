<?php

namespace App\Http\Controllers;

use App\Traffics;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Book;
use Session;

class ViewTrafficController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $m = null;
        $y = null;
        $_book = new Book();
        $books = $_book->select(['book_id', 'title'])->where('author', '=', Session::get('user')->user_id)->get();
        $year = date("Y");
        $month = date("m");
        if ($request->get('time')) {
            $time = explode('/', $request->get('time'));
            $year = $time[0];
            $month = $time[1];
            // dd($request->get('time'));
        }
        if ($request->get('stories')) {
            if ($request->get('stories') == "all") {
                $id = null;
            } else {
                $id = $request->get('stories');
            }
        }
        $_year = $year - 1;
        $date_from = "$_year-01-01";
        $date_from = strtotime($date_from);
        $date_to = date('y') . "-" . date('m') . "-28";
        $date_to = strtotime($date_to); // Convert date to a UNIX timestamp  
        // Loop from the start date to end date and output all dates inbetween  
        for ($i = $date_to; $i > $date_from; $i -= (86400 * 30)) {
            $dropdown[$i] = date("Y/m", $i);
        }
        if ($id == null) {
            $traffics = Traffics::select([
                DB::raw('count(traffic_id) as count'),
                DB::raw('DAY(DATE(created_at)) as day'),
            ])->whereYear('created_at', $year)
                ->whereMonth('created_at', '=', $month)
                ->groupby('day')
                ->get();
        } else {
            $traffics = Traffics::select([
                DB::raw('count(traffic_id) as count'),
                DB::raw('DAY(DATE(created_at)) as day'),
            ])->whereYear('created_at', $year)
                ->whereMonth('created_at', '=', $month)
                ->where('book_id', '=', $id)
                ->groupby('day')
                ->get();
        }
        $data['thismonth'] = (array_sum(array_column($traffics->toArray(), 'count')));
        $data['year'] = $year;
        $data['month'] = date('F', mktime(0, 0, 0, str_pad($month, 2, '0', STR_PAD_LEFT)));
        $book = $_book->where('author', '=', Session::get('user')->user_id)->where('book_id', '=', $id)->first();
        $data['infotraffic'] = $book;
        $data['books'] = $books;
        $tes = DB::select("select DAY(LAST_DAY('$year-$month-01')) as COUNT;");
        $lastday = $tes[0]->COUNT;
        for ($i = 1; $i <= $lastday; $i++) {
            $traffic[$i]['label'] = $i;
            $traffic[$i]['value'] = 0;
            for ($j = 0; $j < count($traffics); $j++) {
                if ($i == $traffics[$j]->day) {
                    $traffic[$i]['value'] = $traffics[$j]->count;
                }
            }
        }
        $traf = "";
        for ($i = 1; $i <= ($lastday); $i++) {
            $traf .= "{label : '" . $traffic[$i]['label'] . "', value: " . $traffic[$i]['value'] . "},";
        }
        return view('viewtraffic', array('data' => $data, 'traffic' => json_encode($traf), 'dropdown' => $dropdown));
    }
    public function addtraffics($bookid)
    {
        $_traffics = new Traffics();
        $_traffics->ip_address = $this->getIP();
        $_traffics->book_id = $bookid;
        $saved = $_traffics->save();
        if ($saved == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}
