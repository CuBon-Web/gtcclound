import { HTTP } from '../../core/plugins/http'

export const addProcessStep = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/process-step/create', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const listProcessStep = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/process-step/list', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const detailProcessStep = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/process-step/edit/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};

export const deleteProcessStep = ({ commit }, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/process-step/delete/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        });
    });
};
