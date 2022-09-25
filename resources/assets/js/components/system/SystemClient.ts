import AbstractClient from '@root/shared/AbstractClient';
import { System } from './System';

const SYSTEM_URL = 'api/system';

class SystemClient extends AbstractClient {
  getSystems() {
    return this.get(SYSTEM_URL);
  }

  createSystem(system: System) {
    return this.post(SYSTEM_URL, system.toRequest());
  }

  updateSystem(system: System) {
    return this.put(`${SYSTEM_URL}/${system.id}`, system.toRequest());
  }

  deleteSystem(system: System) {
    return this.delete(`${SYSTEM_URL}/${system.id}`);
  }
}

export default SystemClient
