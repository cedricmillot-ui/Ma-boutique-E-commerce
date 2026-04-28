<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        // 1. Amélioration du log de CRÉATION
        static::created(function ($model) {
            $name = class_basename($model);
            $message = "Nouveau $name créé.";

            // Personnalisation selon le modèle
            if ($name === 'Order') {
                $message = "📦 Commande #{$model->id} reçue (Total: {$model->total_price}€)";
            } elseif ($name === 'User') {
                $message = "👤 Nouvel utilisateur inscrit : {$model->name}";
            }

            $model->recordLog('CREATION', $message);
        });

        // 2. Log de MODIFICATION (déjà bien, mais nettoyons le message)
        static::updated(function ($model) {
            $changes = $model->getChanges();
            unset($changes['updated_at'], $changes['password'], $changes['remember_token']);

            if (!empty($changes)) {
                $details = collect($changes)->map(function ($value, $key) use ($model) {
                    $old = $model->getOriginal($key);
                    return "[$key]: '$old' → '$value'";
                })->implode(' | ');

                $name = class_basename($model);
                $prefix = ($name === 'Order') ? "📦 Commande #{$model->id}" : "Mise à jour $name";
                
                $model->recordLog('MODIFICATION', "$prefix : $details");
            }
        });

        static::deleted(fn ($model) => $model->recordLog('SUPPRESSION', class_basename($model) . " supprimé."));
    }

    protected function recordLog($action, $description)
    {
        ActivityLog::create([
            'user_id' => Auth::id() ?? ($this->user_id ?? null),
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip() ?? '127.0.0.1',
        ]);
    }
}