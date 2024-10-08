<?php
namespace App\Services;

class VacationCodeGenerator
{
    private $baseCode = '033'; // Base code qui ne change pas
    private $daySuffixes = ['WA1', 'WB1', 'WC1', 'WD1']; // Suffixes pour les vacations de jour
    private $nightSuffixes = ['WE1', 'WF1', 'WG1', 'WH1']; // Suffixes pour les vacations de nuit

    public function generateVacationCodes($demandeId, $clientId, $isNight = false, $isFullDay = false)
    {
        $codes = [];
        $suffixes = $isNight ? $this->nightSuffixes : $this->daySuffixes;

        // Préfixe basé sur le type de vacation
        $typePrefix = $isNight ? 'LIONNE' : 'LION';

        // Si c'est une vacation de jour entière, générer pour 4 agents
        if ($isFullDay) {
            for ($i = 0; $i < 2; $i++) {
                // Codes pour les agents de jour
                $codes[] = 'VAC - ' . $this->baseCode . $demandeId .' ' . $typePrefix . ' ' . $suffixes[$i]; // Agents de jour
                // Codes pour les agents de nuit
                $codes[] = 'VAC - ' . $this->baseCode . $demandeId  .' '. ' LIONNE ' . $this->nightSuffixes[$i]; // Agents de nuit
            }
        } else {
            // Générer deux codes de vacation pour un seul agent
            for ($i = 0; $i < 2; $i++) {
                $codes[] = 'VAC - ' . $this->baseCode . $demandeId .' '  . $typePrefix . ' ' . $suffixes[$i];
            }
        }

        return $codes;
    }
}