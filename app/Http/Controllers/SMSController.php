<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Http;
// use PhpOffice\PhpSpreadsheet\IOFactory;
// use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SMSController extends Controller
{

    public function index()
    {
        return view('sms');
    }

    // Traiter le formulaire
    public function sendMessage(Request $request)
    {
        $request->validate([
            'sender' => 'required|string',
            'recipients' => 'nullable|string',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:xlsx,xls',
        ]);

        $sender = $request->input('sender');
        $content = $request->input('content');
        $recipients = $request->input('recipients') ? explode(',', $request->input('recipients')) : [];
        
        // Traiter le fichier Excel s'il est présent
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $data = Excel::toCollection(null, $path)->first();

            foreach ($data as $row) {
                if (isset($row['numero']) && preg_match('/^\d{13}$/', $row['numero'])) {
                    $recipients[] = $row['numero'];
                }
            }
        }

        $invalidNumbers = [];
        $errors = [];
        $validNumbers = array_filter($recipients, function ($number) {
            return preg_match('/^\d{13}$/', $number);
        });

        foreach ($validNumbers as $recipient) {
            $url = "http://192.168.78.128:1401/send";

            $response = Http::get($url, [
                'username' => 'smppclient1',
                'password' => 'password',
                'from' => $sender,
                'to' => $recipient,
                'content' => $content,
            ]);

            if (!$response->successful()) {
                $errors[] = $recipient;
            }
        }

        // Retourner le résultat
        if ($errors) {
            return back()->with('error', 'Erreur d\'envoi vers : ' . implode(', ', $errors));
        }
        return back()->with('success', 'Messages envoyés avec succès à ' . count($validNumbers) . ' numéros.');
    }
    // // Fonction de validation de numéro
    // private function validateNumber($number)
    // {
    //     return preg_match('/^\d{13}$/', $number) === 1;
    // }

    // // Page principale pour envoyer des SMS
    // public function index()
    // {
    //     return view('sms');
    // }

    // // Méthode pour envoyer des SMS
    // public function sendMessage(Request $request)
    // {
    //     $sender = $request->input('sender');
    //     $recipients = $request->input('recipients') ? explode(',', $request->input('recipients')) : [];
    //     $content = $request->input('content');

    //     // Traiter le fichier Excel s'il est fourni
    //     if ($request->hasFile('file')) {
    //         try {
    //             $file = $request->file('file');
    //             $spreadsheet = IOFactory::load($file->getPathname());
    //             $worksheet = $spreadsheet->getActiveSheet();
    //             $data = $worksheet->toArray();

    //             // Supposer que la première ligne est un en-tête
    //             $headerRow = array_shift($data);
    //             $numeroIndex = array_search('numero', array_map('strtolower', $headerRow));

    //             if ($numeroIndex !== false) {
    //                 foreach ($data as $row) {
    //                     $number = (string)$row[$numeroIndex];
    //                     if ($this->validateNumber($number)) {
    //                         $recipients[] = $number;
    //                     }
    //                 }
    //             } else {
    //                 return back()->with('error', 'Le fichier Excel doit contenir une colonne nommée "numero".');
    //             }
    //         } catch (Exception $e) {
    //             return back()->with('error', 'Erreur lors du traitement du fichier Excel : ' . $e->getMessage());
    //         }
    //     }

    //     // Valider les numéros
    //     $invalidNumbers = array_filter($recipients, function($num) {
    //         return !$this->validateNumber($num);
    //     });

    //     if (!empty($invalidNumbers)) {
    //         return back()->with('error', 'Les numéros suivants sont invalides : ' . implode(', ', $invalidNumbers));
    //     }

    //     // Envoyer le message à chaque destinataire
    //     $errors = [];
    //     $successCount = 0;

    //     foreach ($recipients as $recipient) {
    //         try {
    //             $url = "http://192.168.78.128:1401/send?username=smppclient1&password=password&from={$sender}&to={$recipient}&content={$content}";
    //             $response = Http::get($url);

    //             if ($response->successful()) {
    //                 $successCount++;
    //             } else {
    //                 $errors[] = $recipient;
    //             }
    //         } catch (Exception $e) {
    //             $errors[] = $recipient;
    //         }
    //     }

    //     // Gérer les résultats
    //     if (!empty($errors)) {
    //         return back()
    //             ->with('error', 'Erreur lors de l\'envoi des messages aux numéros suivants : ' . implode(', ', $errors))
    //             ->with('successCount', $successCount);
    //     }

    //     return back()
    //         ->with('success', 'Tous les messages ont été envoyés avec succès.')
    //         ->with('successCount', $successCount);
    // }

    // // Méthode pour recevoir des SMS
    // public function receiveSMS(Request $request)
    // {
    //     try {
    //         $msgId = $request->input('id');
    //         $sender = $request->input('from');
    //         $recipient = $request->input('to');
    //         $message = $request->input('content');

    //         // Journaliser le message
    //         Log::channel('sms_received')->info("Message reçu de {$sender} à {$recipient} : {$message}");

    //         // Vous pouvez ajouter ici la logique WebSocket si nécessaire

    //         return response('ACK/Jasmin');
    //     } catch (Exception $e) {
    //         return response('Erreur : ' . $e->getMessage(), 500);
    //     }
    // }
}
?>