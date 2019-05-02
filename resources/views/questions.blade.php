-Why add the organizers->Json? I tried it both ways(with and without) and got the same result.

-Is it important to add the meta name="csrf-token" content="{{ csrf_token() }}"? I am now getting an error when I try to axios.get from the locations rest library.

-Do I really need const headers = {'Content-Type': 'application/x-www-form-urlencoded'}; ? when I remove it and the argument headers from the axios it still works.

-You have (input !== null) and (input.id !== null). Why do you need both?

-How does import _ from 'lodash' work? Is that what allows fields to be input?






