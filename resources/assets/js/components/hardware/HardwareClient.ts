import AbstractClient from '@root/shared/AbstractClient';
import { Hardware } from './Hardware';

const HARDWARE_URL = 'api/hardware';

class HardwareClient extends AbstractClient {
  getHardwares() {
    return this.get(HARDWARE_URL);
  }

  createHardware(hardware: Hardware) {
    return this.post(HARDWARE_URL, hardware.toRequest());
  }

  updateHardware(hardware: Hardware) {
    return this.put(`${HARDWARE_URL}/${hardware.id}`, hardware.toRequest());
  }

  deleteHardware(hardware: Hardware) {
    return this.delete(`${HARDWARE_URL}/${hardware.id}`);
  }

  deleteUserHardware(hardware: Hardware) {
    return this.delete(`${HARDWARE_URL}/user/${hardware.id}`);
  }

  addUserHardware(hardware: Hardware, userId: number) {
    return this.post(`${HARDWARE_URL}/user/${hardware.id}`, { user_id: userId });
  }
}

export default HardwareClient
