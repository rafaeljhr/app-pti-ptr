<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notificacao;

class NotificationController extends Controller
{

    public function hideNotification(Request $request)
    {

        $notificacao = Notificacao::where('id', $request->id)->first();
        $notificacao->estado = 0;
        $notificacao->save();

    }


}