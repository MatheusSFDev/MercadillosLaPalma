<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Services\FleaMarketService;
use App\Services\StallService;
use Illuminate\Http\Request;
use App\Http\Requests\StallStoreRequest;
use App\Http\Requests\StallUpdateRequest;
use App\Models\FleaMarket;
use App\Models\Schedule;
use App\Models\Stall;
use App\Models\User;

class AdminController extends Controller
{
    protected $fleaMarketService;
    protected $stallService;

    /**
     * Display a listing of the resource.
     */


    public function controlPanel()
    {
        return view("admin.controlPanel");
    }

    public function __construct(FleaMarketService $fleaMarketService, StallService $stallService)
    {
        $this->fleaMarketService = $fleaMarketService;
        $this->stallService = $stallService;
    }


    public function indexMarket()
    {
        $mercadillos = $this->fleaMarketService->getAllBasic();

        return view('admin.markets', compact('mercadillos'));
    }





    public function show($id)
    {
        $mercadillo = $this->fleaMarketService->getFullById($id);

        return view('admin.controlPanel', compact('mercadillo'));
    }

    public function createStall(StallStoreRequest $request, $mercadilloId)
    {
        $data = $request->validated();
        $data['flea_market_id'] = $mercadilloId;

        $this->stallService->create($data);

        return back()->with('success', 'Puesto creado correctamente.');
    }

    public function updateStall(StallUpdateRequest $request, Stall $stall)
    {
        $data = $request->validated();

        $this->stallService->update($stall, $data);

        return back()->with('success', 'Puesto actualizado correctamente.');
    }

    public function activateStall(Stall $stall)
    {
        $this->stallService->activate($stall);

        return back()->with('success', 'Puesto activado.');
    }

    public function deactivateStall(Stall $stall)
    {
        $this->stallService->deactivate($stall);

        return back()->with('success', 'Puesto desactivado.');
    }

    public function deleteStall(Stall $stall)
    {
        $this->stallService->delete($stall);

        return back()->with('success', 'Puesto eliminado.');
    }
    public function createSchedule(ScheduleRequest $request, $mercadilloId)
    {
        $data = $request->validated();
        $data['flea_market_id'] = $mercadilloId;

        Schedule::create($data);

        return back()->with('success', 'Horario creado correctamente.');
    }

    // Actualizar horario
    public function updateSchedule(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return back()->with('success', 'Horario actualizado correctamente.');
    }

    // Eliminar horario
    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Horario eliminado correctamente.');
    }
    public function assignStallToUser(FleaMarket $mercadillo, User $user)
    {
        try {
            $this->stallService->assignStallToUser($user, $mercadillo);
            return back()->with('success', 'Usuario ahora es vendedor (puesto asignado).');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function getStallWithoutR($id)
    {
        $mercadillo = FleaMarket::with([
            'municipality',
            'schedules',
            'holidays',
            'stalls.user',
            'stalls.products'
        ])->findOrFail($id);

        $stallsWithoutDate = $this->stallService
            ->getWithoutRegisterDateByMarket($id);

        return view('admin.controlPanel', compact(
            'mercadillo',
            'stallsWithoutDate'
        ));
    }
   

    public function registerStall(Stall $stall)
    {
        try {
            $this->stallService->registerStall($stall);

            return back()->with('success', 'Puesto dado de alta correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}