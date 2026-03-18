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
        return view('admin.markets');
    }





    public function show($id)
    {
        $fleaMarket = auth()->user()->fleaMarketsAsAdmin()
            ->with(['stalls.user', 'stalls.orders', 'stalls.products', 'municipality'])
            ->findOrFail($id);

        return view('admin.controlPanel', compact('fleaMarket'));
    }

    public function createStall(StallStoreRequest $request, $mercadilloId)
    {
        $data = $request->validated();
        $data['flea_market_id'] = $mercadilloId;

        $this->stallService->create($data);

        return back()->with('success', 'Puesto creado correctamente.');
    }

    public function updateMarket(\App\Http\Requests\FleaMarketUpdateRequest $request, FleaMarket $mercadillo)
    {
        $data = $request->validated();

        $mercadillo->update([
            'address' => $data['address'],
            'img_url' => $data['img_url'] ?? null,
        ]);

   
        if (isset($data['schedules']) && is_array($data['schedules'])) {
            foreach ($data['schedules'] as $day => $vals) {
               
                $opening = $vals['opening_time'] ?? null;
                $closing = $vals['closing_time'] ?? null;
                if ($opening === '') $opening = null;
                if ($closing === '') $closing = null;
                $dayOfWeek = mb_convert_case($day, MB_CASE_TITLE, 'UTF-8');
                $existing = $mercadillo->schedules()->where('day_of_week', $dayOfWeek)->first();
                if ($existing) {
                    $existing->update([
                        'opening_time' => $opening,
                        'closing_time' => $closing,
                    ]);
                } else {
                    $mercadillo->schedules()->create([
                        'day_of_week' => $dayOfWeek,
                        'opening_time' => $opening,
                        'closing_time' => $closing,
                    ]);
                }
            }
        }

        return redirect()->route('admin.control-panel', $mercadillo->id)
            ->with('success', 'Información del mercadillo actualizada.')
            ->with('tab', 'info');
    }

    public function editStallForm(Stall $stall)
    {
        $fleaMarket = $stall->fleaMarket;
        return view('admin.stalls.edit', compact('stall', 'fleaMarket'));
    }

    public function updateStall(StallUpdateRequest $request, Stall $stall)
    {
        $data = $request->validated();
        $this->stallService->update($stall, $data);

        return redirect()->route('admin.control-panel', $stall->flea_market_id)->with('success', 'Puesto actualizado correctamente.');
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

    
    public function updateSchedule(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return back()->with('success', 'Horario actualizado correctamente.');
    }

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

   
    public function acceptStalls(Request $request)
    {
        $data = $request->validate([
            'stall_ids' => 'required|array',
            'stall_ids.*' => 'integer'
        ]);

        $updated = $this->stallService->acceptRequests($data['stall_ids']);

        return back()->with('success', "$updated puestos aprobados.");
    }

 
    public function unregisteredCounts()
    {
        $counts = $this->stallService->countUnregisteredByMarket();

        return response()->json($counts);
    }

}