<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar ? $this->getAvatarUrl() : null,
            'is_admin' => $this->is_admin,
            'email_verified_at' => $this->email_verified_at,
            'current_plan' => $this->getPlanName(),
        ];
    }

    private function getAvatarUrl()
    {
        $disk = config('app.env') === 'local' ? 'public' : 's3';

        /** @var \Illuminate\Filesystem\FilesystemManager $storage */
        $storage = Storage::disk($disk);

        return $storage->url($this->avatar);
    }

    /**
     * Retorna o nome do plano baseado no Stripe Price ID, se estiver ativo.
     */
    private function getPlanName(): string|null
    {
        $subscription = $this->subscriptions()->where('stripe_status', 'active')->first();

        if (!$subscription) {
            return null; // Se não houver assinatura ativa, retorna null
        }

        $plans = [
            config('stripe.pro_price_id') => 'PRO',
            config('stripe.basic_price_id') => 'BASIC',
            config('stripe.yearly_pro_price_id') => 'PRO (ANUAL)',
            config('stripe.yearly_basic_price_id') => 'BASIC (ANUAL)',
        ];

        return $plans[$subscription->stripe_price] ?? null;
    }
}
