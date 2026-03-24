@extends('components.header')
@section('docu', 'Pending Accounts')
@section('page','PENDNG ACCOUNTS')
<x-accounts :userData="$userData" sortBy="sortPendingUsersBy" orderBy="orderPendingUsersBy" sortByClass="sortPendingUsersBy" searchUsersName="searchPendingUsers"
searchUsersId="searchPendingUsers"> 
</x-accounts>   
