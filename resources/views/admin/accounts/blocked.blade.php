@extends('components.header')
@section('docu', 'Blocked Accounts')
@section('page','BLOCKED ACCOUNTS')
    <x-accounts :userData="$userData" sortBy="sortBlockUserBy" orderBy="orderBlockUserBy" sortByClass="sortBlockUserBy" searchUsersName="searchAllBlockedUsers"
    searchUsersId="searchBlockedUser"> 
</x-accounts>   
