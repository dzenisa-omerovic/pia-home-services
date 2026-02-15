<div>
    <style>
        .availability-card {
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            padding: 8px 10px 14px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.04);
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
        .availability-card .panel-body .form-horizontal {
            max-width: 640px;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            transform: translateX(-6px);
        }
        .availability-card .panel-heading {
            font-weight: 700;
            color: #0b3b5b;
        }
        .availability-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: nowrap;
            width: 600px;
            margin: 0 auto 10px;
        }
        .availability-row > .col-sm-3,
        .availability-row > .col-sm-2 {
            float: none;
            width: auto;
            padding: 0;
        }
        .availability-row .day-label {
            width: 120px;
            font-weight: 600;
            color: #334155;
            text-align: right;
        }
        .availability-row .active-toggle {
            width: 90px;
        }
        .availability-row .time-col {
            width: 170px;
        }
        .availability-actions {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            padding-bottom: 10px;
        }
        .availability-actions .btn {
            min-width: 140px;
        }
        .exception-row {
            display: grid;
            grid-template-columns: 140px 160px 160px 140px;
            gap: 12px;
            align-items: start;
            justify-content: center;
        }
        .exception-row .control-label {
            font-weight: 600;
            margin-bottom: 0;
            line-height: 1.1;
        }
        .exception-row .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: flex-start;
        }
        .exception-row .field.inline {
            flex-direction: row;
            align-items: center;
            gap: 8px;
            padding-top: 18px;
        }
        .exception-actions {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .exception-actions {
            display: flex;
            justify-content: flex-end;
        }
        .exception-actions .btn {
            min-width: 140px;
        }
        .exception-cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }
        @media (max-width: 991px) {
            .exception-row {
                grid-template-columns: 1fr 1fr;
                justify-content: stretch;
            }
            .exception-actions {
                grid-column: 1 / -1;
                justify-content: flex-end;
            }
            .exception-cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 600px) {
            .exception-row {
                grid-template-columns: 1fr;
            }
            .exception-cards {
                grid-template-columns: 1fr;
            }
        }
        .exception-card {
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            padding: 10px 12px;
            background: #fff;
            box-shadow: 0 6px 14px rgba(0,0,0,0.04);
        }
        .exception-card-title {
            font-weight: 700;
            color: #0b3b5b;
            margin-bottom: 6px;
        }
        .exception-card-meta {
            font-size: 12px;
            color: #6b7280;
            display: grid;
            gap: 4px;
        }
        .availability-table th {
            white-space: nowrap;
        }
        .availability-table td {
            vertical-align: middle;
        }
    </style>
    <div class="section-title-01 honmob">
        <div class="bg_parallax image_02_parallax"></div>
        <div class="opacy_bg_02">
            <div class="container">
                <h1>Availability</h1>
                <div class="crumbs">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>/</li>
                        <li>Availability</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="content-central">
        <div class="content_info">
            <div class="paddings-mini">
                <div class="container">
                    <div class="row portfolioContainer">
                        <div class="col-md-10 col-md-offset-1 profile1">
                            <div class="panel panel-default availability-card">
                                <div class="panel-heading">Weekly Availability</div>
                                <div class="panel-body">
                                    @if(Session::has('message'))
                                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                    @endif
                                    <form class="form-horizontal" wire:submit.prevent="saveWeekly">
                                        <datalist id="time-options">
                                            <option value="00:00"></option>
                                            <option value="00:30"></option>
                                            <option value="01:00"></option>
                                            <option value="01:30"></option>
                                            <option value="02:00"></option>
                                            <option value="02:30"></option>
                                            <option value="03:00"></option>
                                            <option value="03:30"></option>
                                            <option value="04:00"></option>
                                            <option value="04:30"></option>
                                            <option value="05:00"></option>
                                            <option value="05:30"></option>
                                            <option value="06:00"></option>
                                            <option value="06:30"></option>
                                            <option value="07:00"></option>
                                            <option value="07:30"></option>
                                            <option value="08:00"></option>
                                            <option value="08:30"></option>
                                            <option value="09:00"></option>
                                            <option value="09:30"></option>
                                            <option value="10:00"></option>
                                            <option value="10:30"></option>
                                            <option value="11:00"></option>
                                            <option value="11:30"></option>
                                            <option value="12:00"></option>
                                            <option value="12:30"></option>
                                            <option value="13:00"></option>
                                            <option value="13:30"></option>
                                            <option value="14:00"></option>
                                            <option value="14:30"></option>
                                            <option value="15:00"></option>
                                            <option value="15:30"></option>
                                            <option value="16:00"></option>
                                            <option value="16:30"></option>
                                            <option value="17:00"></option>
                                            <option value="17:30"></option>
                                            <option value="18:00"></option>
                                            <option value="18:30"></option>
                                            <option value="19:00"></option>
                                            <option value="19:30"></option>
                                            <option value="20:00"></option>
                                            <option value="20:30"></option>
                                            <option value="21:00"></option>
                                            <option value="21:30"></option>
                                            <option value="22:00"></option>
                                            <option value="22:30"></option>
                                            <option value="23:00"></option>
                                            <option value="23:30"></option>
                                        </datalist>
                                        @php
                                            $dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                                        @endphp
                                        @foreach ($dayNames as $i => $dayName)
                                            <div class="form-group availability-row">
                                                <div class="col-sm-2 active-toggle">
                                                    <label style="margin-top: 7px;">
                                                        <input type="checkbox" wire:model="week.{{ $i }}.is_active"> Active
                                                    </label>
                                                </div>
                                                <label class="control-label col-sm-3 day-label">{{ $dayName }}</label>
                                                <div class="col-sm-3 time-col">
                                                    <input type="time" class="form-control" list="time-options" wire:model="week.{{ $i }}.start_time">
                                                </div>
                                                <div class="col-sm-3 time-col">
                                                    <input type="time" class="form-control" list="time-options" wire:model="week.{{ $i }}.end_time">
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="availability-actions">
                                            <button type="submit" class="btn btn-success">Save Weekly</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="panel panel-default availability-card" style="margin-top: 20px;">
                                <div class="panel-heading">Exceptions</div>
                                <div class="panel-body exception-grid">
                                    <form class="form-horizontal" wire:submit.prevent="addException">
                                        <div class="exception-row">
                                            <div class="field">
                                                <label class="control-label">Date</label>
                                                <input type="date" class="form-control" wire:model="exception_date">
                                                @error('exception_date') <p class="text-danger">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="field">
                                                <label class="control-label">Start Time</label>
                                                <input type="time" class="form-control" list="time-options" wire:model="exception_start_time">
                                            </div>
                                            <div class="field">
                                                <label class="control-label">End Time</label>
                                                <input type="time" class="form-control" list="time-options" wire:model="exception_end_time">
                                            </div>
                                            <div class="field">
                                                <label class="control-label">Available</label>
                                                <label class="inline" style="margin: 0;">
                                                    <input type="checkbox" wire:model="exception_is_available"> Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="exception-actions">
                                            <button type="submit" class="btn btn-info">Save Exception</button>
                                        </div>
                                    </form>

                                    <hr>
                                    <div class="exception-cards">
                                        @forelse ($exceptions as $ex)
                                                <div class="exception-card">
                                                <div class="exception-card-title">{{ \Illuminate\Support\Carbon::parse($ex->date)->toDateString() }}</div>
                                                <div class="exception-card-meta">
                                                    <div>Available: <strong>{{ $ex->is_available ? 'Yes' : 'No' }}</strong></div>
                                                    <div>Start: <strong>{{ $ex->start_time ? \Illuminate\Support\Carbon::parse($ex->start_time)->format('H:i') : '—' }}</strong></div>
                                                    <div>End: <strong>{{ $ex->end_time ? \Illuminate\Support\Carbon::parse($ex->end_time)->format('H:i') : '—' }}</strong></div>
                                                </div>
                                            </div>
                                        @empty
                                            <div>No exceptions.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
