<?php
namespace ChatOnCloud\Ticket;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TicketClient
{
    /**
     * Cria um novo chamado via API remota da ChatOnCloud.
     *
     * @param string $sSubject
     * @param string $sDescription
     * @param string $sPriority
     * @param UploadedFile[]|null $aAttachments
     * @return array|null
     */
    public function create(
        string $sSubject,
        string $sDescription,
        string $sPriority = 'média',
        ?array $aAttachments = []
    ): ?array {
        try {
            $sUrl = config('chatoncloud.url');
            $sToken = config('chatoncloud.token');

            $aData = [
                'subject' => $sSubject,
                'description' => $sDescription,
                'priority' => $sPriority,
            ];

            $oRequest = Http::withToken($sToken)->asMultipart();

            foreach ($aAttachments as $i => $oFile) {
                if ($oFile instanceof UploadedFile) {
                    $oRequest->attach(
                        "attachments[$i]",
                        file_get_contents($oFile->getRealPath()),
                        $oFile->getClientOriginalName()
                    );
                }
            }

            $oResponse = $oRequest->post($sUrl, $aData);

            if ($oResponse->failed()) {
                Log::error('[ChatOnCloud SDK] Falha ao criar ticket.', [
                    'status' => $oResponse->status(),
                    'body' => $oResponse->body()
                ]);
                return null;
            }

            return $oResponse->json();

        } catch (\Throwable $oException) {
            Log::error('[ChatOnCloud SDK] Erro ao criar ticket.', [
                'exception' => $oException->getMessage()
            ]);
            return null;
        }
    }
}
