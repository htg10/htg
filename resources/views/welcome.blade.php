<td>
    <form method="POST" action="">
        @csrf
        <select name="status" onchange="updateSelectStyle(this); this.form.submit()"
            class="form-select {{ $lead->deal_status == 'pending' ? 'border border-danger text-danger' : '' }}
                                                {{ $complaint->deal_status == 'follow up' ? 'border border-success text-success' : '' }} {{ $complaint->deal_status == 'deal complete' ? 'border border-success text-success' : '' }}">
            <option value="pending" class="text-danger" {{ $complaint->deal_status == 'pending' ? 'selected' : '' }}>
                Pending
            </option>
            <option value="follow up" class="text-success" {{ $complaint->deal_status == 'follow up' ? 'selected' : '' }}>
                Follow Up
            </option>
            <option value="deal complete" class="text-success" {{ $complaint->deal_status == 'complete' ? 'selected' : '' }}>
                Deal Complete
            </option>
        </select>
    </form>
</td>
