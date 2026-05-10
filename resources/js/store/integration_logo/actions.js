import { HTTP } from '../../core/plugins/http'

export const addIntegrationLogo = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/integration-logo/create', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const listIntegrationLogo = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/integration-logo/list', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const detailIntegrationLogo = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/integration-logo/edit/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const deleteIntegrationLogo = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/integration-logo/delete/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};
