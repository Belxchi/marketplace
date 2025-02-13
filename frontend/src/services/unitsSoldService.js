import api from './api';

export const fetchUnitsSold = () => {
    return api.get('/units-sold');
};