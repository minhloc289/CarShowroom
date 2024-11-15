@extends('Backend.dashboard.layout')

@section('content') 
    <x-breadcrumbs breadcrumb="user" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xl-12">
                    <!--begin::Tables Widget 9-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Thông tin thành viên</span>
                                <span class="text-muted mt-1 fw-bold fs-7">Số lượng nhân viên | {{$employees->count()}}</span>
                            </h3>
                            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-light btn-active-primary d-flex align-items-center gap-1">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <span class="text-muted">New Member</span>
                                </a>
                            </div>                            
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="w-25px">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        data-kt-check="true" data-kt-check-target=".widget-9-check" />
                                                </div>
                                            </th>
                                            <th class="min-w-150px">Tên nhân viên</th>
                                            <th class="min-w-140px">Vị trí</th>
                                            <th class="min-w-120px">Trạng thái</th>
                                            <th class="min-w-100px text-end">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            {{-- Checkbox --}}
                                            <td>
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input widget-9-check" type="checkbox"
                                                        value="1" />
                                                </div>
                                            </td>

                                            {{-- Tên nhân viên --}}
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-30px symbol-md-40px me-3" 
                                                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                        <img src="{{ $employee->image ? asset('storage/' . $employee->image) : '/assets/media/avatars/150-11.jpg' }}" 
                                                            alt="user" class="w-full h-full object-cover rounded-full" />
                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="javascript:void(0);" 
                                                            class="text-dark fw-bolder text-hover-primary fs-6"
                                                            onclick="showEmployeeDetails({{ $employee->id }})">
                                                            {{ $employee->name }}
                                                        </a>
                                                        <span class="text-muted fw-bold text-muted d-block fs-7">{{$employee->description}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            {{-- Vị trí --}}
                                            <td>
                                                <span class="text-dark fw-bolder text-hover-primary d-block fs-6">
                                                    {{ $employee->is_quanly ? 'Quản lý' : 'Nhân viên' }}
                                                </span>
                                                <span class="text-muted fw-bold text-muted d-block fs-7">{{ $employee->position }}</span>
                                            </td>

                                            {{-- Trạng thái --}}
                                            <td class="text-end">
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-2">
                                                        <span class="text-muted me-2 fs-7 fw-bold">50%</span>
                                                    </div>
                                                    <div class="progress h-6px w-100">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Thao tác --}}
                                            <td>
                                                <div class="d-flex justify-content-end flex-shrink-0">
                                                    <a href="{{route('user.edit', $employee->id)}}"
                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3"
                                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                    fill="black" />
                                                                <path
                                                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                    fill="black" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <!-- Delete Icon with Form -->
                                                    <form action="{{ route('user.delete', $employee->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa nhân viên này?');" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!-- Employee Detail Modal -->
                            <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        <div class="modal-header border-0 pb-3">
                                            <h5 class="modal-title font-semibold text-lg" id="employeeDetailModalLabel">Thông tin chi tiết nhân viên</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body px-6 py-4">
                                            <!-- Employee details will be loaded here dynamically -->
                                            <div id="employeeDetailContent" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <!-- Placeholder content. This will be replaced dynamically with AJAX. -->
                                                <div class="col-span-2 flex items-center space-x-4 mb-4">
                                                    <div class="w-16 h-16 rounded-full overflow-hidden">
                                                        <img id="employeeImage" src="/assets/media/avatars/150-11.jpg" alt="user" class="w-full h-full object-cover">
                                                    </div>
                                                    <div>
                                                        <h4 id="employeeName" class="font-bold text-xl text-gray-800">Loading...</h4>
                                                        <p id="employeePosition" class="text-gray-500">Loading...</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-span-1">
                                                    <label class="text-gray-600 font-medium">Email</label>
                                                    <div class="p-2 border rounded-md bg-gray-100 text-gray-800" id="employeeEmail">Loading...</div>
                                                </div>
                                                <div class="col-span-1">
                                                    <label class="text-gray-600 font-medium">Phone</label>
                                                    <div class="p-2 border rounded-md bg-gray-100 text-gray-800" id="employeePhone">Loading...</div>
                                                </div>
                                                <div class="col-span-1">
                                                    <label class="text-gray-600 font-medium">Address</label>
                                                    <div class="p-2 border rounded-md bg-gray-100 text-gray-800" id="employeeAddress">Loading...</div>
                                                </div>
                                                <div class="col-span-1">
                                                    <label class="text-gray-600 font-medium">Description</label>
                                                    <div class="p-2 border rounded-md bg-gray-100 text-gray-800" id="employeeDescription">Loading...</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-start bg-gray-100 border-0 py-3 px-6">
                                            <button type="button" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Employee Detail Modal-->

                            <!--end::Table container-->
                            <div class="d-flex justify-content-end mt-5 ">
                                {{ $employees->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 9-->
                </div>
            </div>
        </div>
    </div>
@endsection