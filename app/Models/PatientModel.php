<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table      = 'patients';
    protected $primaryKey = 'patient_id';

    protected $allowedFields = [
        'last_name', 'name', 'middle_name',
        'sex', 'age', 'birthdate', 'contact', 'department',
    ];

    public function getRecords(
        $start,
        $length,
        $searchValue  = '',
        $orderColumn  = 'p.last_name',
        $orderDir     = 'asc'
    ) {
        // ── Separate COUNT query (no GROUP BY, no LIMIT) ─────────────────
        // Counting distinct patients that match the search, regardless of
        // how many parent rows they have. Using a clean builder avoids the
        // clone-after-groupBy bug that previously broke the filtered count.
        $countBuilder = $this->db->table('patients p');
        $countBuilder->join('patient_parents pp', 'pp.patient_id = p.patient_id', 'left');
        $countBuilder->join('parents pr',         'pr.parent_id  = pp.parent_id',  'left');

        if (!empty($searchValue)) {
            $countBuilder->groupStart()
                ->like('p.last_name',   $searchValue)
                ->orLike('p.name',        $searchValue)
                ->orLike('p.middle_name', $searchValue)
                ->orLike('pr.last_name',  $searchValue)
                ->orLike('pr.name',       $searchValue)
                ->groupEnd();
        }

        // COUNT(DISTINCT) so that patients with multiple parents aren't
        // counted more than once.
        $countBuilder->select('COUNT(DISTINCT p.patient_id) AS cnt', false);
        $filtered = (int) ($countBuilder->get()->getRowArray()['cnt'] ?? 0);

        // ── Main DATA query ──────────────────────────────────────────────
        $builder = $this->db->table('patients p');

        $builder->select("
            p.*,
            GROUP_CONCAT(
                CONCAT(pr.last_name, ', ', pr.name, ' (', pp.relationship, ')')
                ORDER BY pr.last_name
                SEPARATOR ' | '
            ) AS parents
        ", false);

        $builder->join('patient_parents pp', 'pp.patient_id = p.patient_id', 'left');
        $builder->join('parents pr',         'pr.parent_id  = pp.parent_id',  'left');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('p.last_name',   $searchValue)
                ->orLike('p.name',        $searchValue)
                ->orLike('p.middle_name', $searchValue)
                ->orLike('pr.last_name',  $searchValue)
                ->orLike('pr.name',       $searchValue)
                ->groupEnd();
        }

        $builder->groupBy('p.patient_id');
        $builder->orderBy($orderColumn, $orderDir);
        $builder->limit($length, $start);

        $data = $builder->get()->getResultArray();

        return [
            'data'     => $data,
            'filtered' => $filtered,
        ];
    }
}