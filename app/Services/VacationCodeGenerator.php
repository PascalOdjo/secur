<?php

namespace App\Services;

/**
 * VacationCodeGenerator
 * 
 * Generates vacation codes based on the CSV planning format:
 * Format: [SITE_CODE]VAC[GROUP][SUBPAIR][SHIFT][TYPE_PREFIX]
 * Examples:
 * - 0331OIFVACKAPJLION (day shift, group K, real contract)
 * - 0331OIFVACKBPJLION (day shift, group K, virtual contract)
 * - 0333OIFVACKAPNLIONNE (night shift, group K, real contract)
 * - 0333OIFVACKAPNLIONNE (night shift, group K, real contract)
 */
class VacationCodeGenerator
{
    // Groupes de vacations: K (réel: KA, virtuel: KB/KC/KD), L (réel: LA, virtuel: LB/LC/LD), etc.
    private $groups = ['K', 'L', 'M', 'N'];

    // Sub-pairs: A (réel), B/C/D (virtuel)
    private $subPairs = ['A', 'B', 'C', 'D'];

    /**
     * Génère les codes de vacation pour chaque groupe (K, L, M, N)
     * Format: [SITE_CODE]VAC[GROUP][SUBPAIR][SHIFT][TYPE_PREFIX]
     * Exemple: 0331OIFVACKAPJLION (0331OIF + VAC + KA + P + JLION) pour jour avec groupe K, site LION
     * 
     * @param int $agentId ID de l'agent (non utilisé mais conservé pour compatibilité)
     * @param object|null $site Objet site contenant site_code et site_type
     * @param bool $isNight Indique si c'est un shift nuit
     * @return array Tableau avec codes de vacation pour chaque groupe (K, L, M, N)
     */
    public function generateVacationCodes($agentId, $site = null, $isNight = false)
    {
        $codes = [];

        // Si pas de site, générer juste les codes sans site_code
        if (!$site) {
            foreach ($this->groups as $group) {
                $subPair = $this->subPairs[0];
                $shift = $isNight ? 'S' : 'P';
                $codes[] = 'VAC' . $group . $subPair . $shift;
            }
            return $codes;
        }

        // Récupérer les infos du site
        $siteCode = $site->site_code ?? 'UNKNOWN';
        $siteType = $site->site_type ?? 'LION';

        // Déterminer le préfixe selon le type de site
        // LION → JLION (jour), LIONNE → NLIONNE (nuit)
        $typePrefix = ($siteType === 'LION' || $siteType === 'JLION') ? 'JLION' : 'NLIONNE';

        // Force prefix based on shift if not already set
        if ($isNight) {
            $typePrefix = 'NLIONNE';
        } else {
            $typePrefix = 'JLION';
        }

        // Générer un code pour chaque groupe (K, L, M, N)
        foreach ($this->groups as $group) {
            $subPair = $this->subPairs[0]; // 'A' = réelle
            $shift = $isNight ? 'S' : 'P'; // S = nuit, P = jour

            // Code complet: SITE_CODE + VAC + GROUP + SUBPAIR + SHIFT + TYPE_PREFIX
            $codes[] = $siteCode . 'VAC' . $group . $subPair . $shift . $typePrefix;
        }

        return $codes;
    }

    /**
     * Génère un code pour une vacation spécifique (réelle ou virtuelle)
     * 
     * @param object $site Objet site contenant site_code
     * @param string $group Groupe (K, L, M, N)
     * @param string $subPair Sub-pair (A, B, C, D) - A pour réelle, B/C/D pour virtuelle
     * @param bool $isNight Shift nuit ou jour
     * @return string Code de vacation
     */
    public function generateSingleCode($site, string $group, string $subPair, bool $isNight = false): string
    {
        $siteCode = $site->site_code ?? 'UNKNOWN';
        $shift = $isNight ? 'S' : 'P';
        $typePrefix = $isNight ? 'NLIONNE' : 'JLION';

        return $siteCode . 'VAC' . $group . $subPair . $shift . $typePrefix;
    }

    /**
     * Retourne les codes virtuels pour un groupe donné
     * @param string $group Groupe (K, L, M, N)
     * @param bool $isNight Indique si c'est un shift nuit
     * @return array Tableau avec codes virtuels (B, C, D)
     */
    public function getVirtualCodes($group, $isNight = false)
    {
        $codes = [];
        $shift = $isNight ? 'S' : 'P';

        // Générer les codes virtuels (B, C, D)
        for ($i = 1; $i < count($this->subPairs); $i++) {
            $codes[] = 'VAC' . $group . $this->subPairs[$i] . $shift;
        }

        return $codes;
    }

    /**
     * Get all groups
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * Get all sub-pairs
     * @return array
     */
    public function getSubPairs(): array
    {
        return $this->subPairs;
    }

    /**
     * Check if a sub-pair is real (A) or virtual (B, C, D)
     * @param string $subPair
     * @return bool
     */
    public function isRealContract(string $subPair): bool
    {
        return $subPair === 'A';
    }

    /**
     * Get count of real and virtual contracts for a group
     * @return array ['real' => 1, 'virtual' => 3, 'total' => 4]
     */
    public function getContractCounts(): array
    {
        return [
            'real' => 1,
            'virtual' => 3,
            'total' => 4,
        ];
    }
}
