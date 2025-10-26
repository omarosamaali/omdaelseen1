<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\UnpaidTripRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnpaidTripRequestsController extends Controller
{
    /**
     * عرض جميع طلبات المستخدم
     */
    public function index()
    {
        $requests = UnpaidTripRequests::with('trip')
            ->forUser(auth()->id())
            ->latest()
            ->paginate(10);

        return view('trip-requests.index', compact('requests'));
    }

    /**
     * تقديم طلب للاشتراك في رحلة غير مدفوعة
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);

        $trip = Trip::findOrFail($request->trip_id);

        // تحقق أن الرحلة غير مدفوعة
        if ($trip->is_paid === 'yes') {
            return back()->with('error', 'هذه الرحلة مدفوعة ولا يمكن التقديم عليها بهذه الطريقة');
        }

        // تحقق أن المستخدم لم يقدم من قبل
        $existingRequest = UnpaidTripRequests::where('user_id', auth()->id())
            ->where('trip_id', $request->trip_id)
            ->first();

        if ($existingRequest) {
            return back()->with('warning', 'لقد قدمت طلب على هذه الرحلة من قبل');
        }

        try {
            DB::beginTransaction();

            $tripRequest = UnpaidTripRequests::create([
                'trip_id' => $request->trip_id,
                'user_id' => auth()->id(),
                'status' => 'pending',
                'reference_number' => 'REF' . random_int( 1000000000, 9999999999),
            ]);

            DB::commit();

            return back()->with('success', 'تم تقديم طلبك بنجاح! سيتم مراجعته قريباً');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء تقديم الطلب، الرجاء المحاولة مرة أخرى');
        }
    }

    /**
     * إلغاء طلب معلق
     */
    public function destroy($id)
    {
        $tripRequest = UnpaidTripRequests::findOrFail($id);

        if ($tripRequest->user_id !== auth()->id()) {
            abort(403, 'غير مصرح لك بهذا الإجراء');
        }

        if (!$tripRequest->isPending()) {
            return back()->with('error', 'لا يمكن إلغاء طلب تم قبوله أو رفضه');
        }

        $tripRequest->delete();

        return back()->with('success', 'تم إلغاء الطلب بنجاح');
    }

    // ==== Admin Methods ====

    /**
     * عرض جميع الطلبات (للأدمن)
     */
    public function adminIndex(Request $request)
    {
        $query = UnpaidTripRequests::with(['trip', 'user']);

        // فلترة حسب الحالة
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // فلترة حسب الرحلة
        if ($request->has('trip_id') && $request->trip_id) {
            $query->where('trip_id', $request->trip_id);
        }

        $requests = $query->latest()->paginate(15);

        return view('admin.trip-requests.index', compact('requests'));
    }

    /**
     * قبول طلب (للأدمن)
     */
    public function approve($id)
    {
        $tripRequest = UnpaidTripRequests::findOrFail($id);

        if (!$tripRequest->isPending()) {
            return back()->with('error', 'هذا الطلب تم معالجته بالفعل');
        }

        $tripRequest->approve();

        // يمكنك إضافة إشعار للمستخدم هنا
        // Notification::send($tripRequest->user, new TripRequestApproved($tripRequest));

        return back()->with('success', 'تم قبول الطلب بنجاح');
    }

    /**
     * رفض طلب (للأدمن)
     */
    public function reject($id)
    {
        $tripRequest = UnpaidTripRequests::findOrFail($id);

        if (!$tripRequest->isPending()) {
            return back()->with('error', 'هذا الطلب تم معالجته بالفعل');
        }

        $tripRequest->reject();

        // يمكنك إضافة إشعار للمستخدم هنا
        // Notification::send($tripRequest->user, new TripRequestRejected($tripRequest));

        return back()->with('success', 'تم رفض الطلب');
    }

    /**
     * عرض طلبات رحلة معينة (للأدمن)
     */
    public function tripRequests($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        $requests = UnpaidTripRequests::with('user')
            ->forTrip($tripId)
            ->latest()
            ->paginate(20);

        return view('admin.trip-requests.trip', compact('trip', 'requests'));
    }
}
