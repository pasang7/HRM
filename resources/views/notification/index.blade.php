@extends('layouts.layout')
@section('title', 'Notifications')
@section('content')
    <div class="newHrProTableGrp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newHrBreadCumb">
                        <h5>Notifications</h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive"  style="--main_header_color : {{ $settings->main_header_color }};">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Notification</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->notifications as $k => $notification)
                                    <?php
                                    $notification->markAsRead();
                                    ?>
                                    <tr>
                                        <td>
                                            {{ date('d M, Y', strtotime($notification->created_at)) }}
                                        </td>
                                        <td>{{ $notification->data['text'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
