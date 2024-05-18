@extends('components.header')
@section('docu', 'Active Accounts')
@section('page','ACTIVE ACCOUNTS')
    <x-accounts :userData="$userData" sortBy="sortBy" orderBy="orderBy" sortByClass="sortBy" searchUsersName="searchAll"
    searchUsersId="searchUser"> 
</x-accounts>   
