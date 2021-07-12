class sessionStore{
  private readonly debug = true
  private sessionId = null as string | null

  getSessionId(): string | null{
    if(this.debug){
      console.log(this.sessionId)
    }
    return this.sessionId
  }

  setSessionId (id: string) {
    if (this.debug) {
      console.log('Session id is now set to ' + id)
    }
    this.sessionId = id
  }

  clearSessionId (): void {
    if (this.debug) {
      console.log('Session id was cleared')
    }
    this.sessionId = null
  }
}

export const SessionStore = new sessionStore()
