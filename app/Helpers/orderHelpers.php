<?php

if (!function_exists('getStatusColor')) {
    function getStatusColor($status)
    {
        switch ($status) {
            case 'completed':
            case 'delivered':
            case 'paid':
                return 'bg-success-500';
            case 'pending':
                return 'bg-warning-500';
            case 'cancelled':
            case 'failed':
            case 'refunded':
                return 'bg-danger-500';
            case 'processing':
            case 'shipped':
                return 'bg-info-500';
            default:
                return 'bg-slate-500';
        }
    }
}
