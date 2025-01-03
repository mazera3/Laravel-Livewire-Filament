<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as Responsable;
use Filament\Pages\Dashboard;
use Illuminate\Http\RedirectResponse;

class CustonLogoutResponse implements Responsable
{

    public function toResponse($request): RedirectResponse
    {
        return redirect()->to(
            Filament::hasLogin() ? Dashboard::getRoutePath() : Filament::getUrl(),
        );
    }
}
